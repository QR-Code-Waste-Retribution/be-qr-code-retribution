<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoice';

    protected $guarded = [];

    public $invoices_formatted = array();

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function users_categories()
    {
        return $this->belongsTo(UserCategories::class, 'users_categories_id');
    }

    public function generate(){
        $users = User::where('district_id', auth()->user()->district_id)
            ->where('role_id', 1)
            ->with(['category'])
            ->get();

        foreach ($users as $user) {
            foreach ($user->category as $category) {          
                $this->create([
                    'category_id' => $category->pivot->category_id,
                    'price' => $category->price,
                    'user_id' => $user->id,
                    'uuid_user' => $user->uuid,
                    'masyarakat_transaction_id' => null,
                    'users_categories_id' => $category->pivot->id,
                    'status' => 0,
                ]);
            }
        }
    }


    public function totalAmountUnpaidAndPaidInvoiceMonthly()
    {
        $currentMonth = date('m');

        $invoice = Invoice::select(
            DB::raw("CASE
                WHEN status = 0 THEN 'unpaid'
                WHEN status = 1 THEN 'paid'
                ELSE 'Unknown'
            END AS status"),
            DB::raw('SUM(price) as total_amount'),
            DB::raw('MAX(updated_at) as updated_at')
        )
            ->whereIn('user_id', function ($query) {
                $query->select('id')
                    ->from('users')
                    ->where('district_id', auth()->user()->district_id);
            })
            ->whereMonth('updated_at', $currentMonth)
            ->groupBy('status')
            ->get();

        return collect($invoice)->mapWithKeys(function ($item) {
            return [$item['status'] => [
                'total' => $item['total_amount'],
                'date' =>  date('d F Y', strtotime($item['updated_at']))
            ]];
        })->toArray();
    }

    public function formatUserInvoice($invoices)
    {
        foreach ($invoices as $item) {
            $this->checkStatusInvoice($item);
        }
        return $this->invoices_formatted;
    }

    public function formatUserAllInvoice($invoices)
    {
        foreach ($invoices as $item) {

            $item['sub_district_name'] = $item->category->sub_district_name;
            $item['address'] = $item->category->address;
            $this->checkStatusInvoiceAndSubDistrict($item);
        }
        return $this->invoices_formatted;
    }

    public function checkStatusInvoice($invoice)
    {
        if (count($this->invoices_formatted) > 0) {
            foreach ($this->invoices_formatted as &$item) {
                if ($invoice['category_id'] == $item['category_id'] && $invoice['status'] == $item['status']) {
                    $item['price'] += $invoice['price'];
                    if (strcmp($invoice['created_at'], $item['created_at']) !== 0) {
                        $item['date'] .= ' - ' . date('d F Y', strtotime($invoice['created_at']));
                    }

                    if ($invoice['address'] === $item['address']) {
                        $item['variants'] .= $invoice['id'] . ",";
                    }

                    return;
                }
            }
        }

        $invoice['date'] = date('d F Y', strtotime($invoice['created_at']));
        array_push($this->invoices_formatted, $invoice);
    }

    public function checkStatusInvoiceAndSubDistrict($invoice)
    {
        if (count($this->invoices_formatted) > 0) {
            foreach ($this->invoices_formatted as &$item) {
                if ($invoice['category_id'] == $item['category_id'] && $invoice['status'] == $item['status'] && $invoice['sub_district_id'] == $item['sub_district_id']) {
                    $item['price'] += $invoice['price'];
                    if (strcmp($invoice['created_at'], $item['created_at']) !== 0) {
                        $item['date'] .= ' - ' . date('d F Y', strtotime($invoice['created_at']));
                    }

                    if ($invoice['address'] === $item['address']) {
                        $item['variants'] .= $invoice['id'] . ",";
                    }

                    return;
                }
            }
        }

        $invoice['date'] = date('d F Y', strtotime($invoice['created_at']));
        $invoice['variants'] .= $invoice['id'] . ",";
        array_push($this->invoices_formatted, $invoice);
    }

    public function getInvoiceById($uuid, $sub_district_id)
    {
        $invoice_user_current_month = $this->select('invoice.*', 'users_categories.user_id', 'users_categories.address', 'sub_districts.name as sub_district_name')
            ->join('users_categories', function ($join) use ($sub_district_id) {
                $join->on('invoice.user_id', '=', 'users_categories.user_id')
                    ->where('users_categories.sub_district_id', '=', $sub_district_id);
            })
            ->join('sub_districts', function ($join) {
                $join->on('users_categories.sub_district_id', '=', 'sub_districts.id');
            })
            ->where('invoice.uuid_user', '=', $uuid)
            ->where(DB::raw('MONTH(invoice.created_at)'), '=', DB::raw('MONTH(CURRENT_DATE())'))
            ->whereColumn('invoice.category_id', '=', 'users_categories.category_id')
            ->orderBy('invoice.created_at');

        $invoice_user_previous_month = $this->select('invoice.*', 'users_categories.user_id', 'users_categories.address', 'sub_districts.name as sub_district_name')
            ->join('users_categories', function ($join) use ($sub_district_id) {
                $join->on('invoice.user_id', '=', 'users_categories.user_id')
                    ->where('users_categories.sub_district_id', '=', $sub_district_id);
            })
            ->join('sub_districts', function ($join) {
                $join->on('users_categories.sub_district_id', '=', 'sub_districts.id');
            })
            ->where('invoice.uuid_user', '=', $uuid)
            ->where('invoice.status', '=', 0)
            ->where(DB::raw('MONTH(invoice.created_at)'), '<', DB::raw('MONTH(CURRENT_DATE())'))
            ->whereColumn('invoice.category_id', '=', 'users_categories.category_id')
            ->orderBy('invoice.created_at')
            ->union($invoice_user_current_month)
            ->get();


        return $invoice_user_previous_month;
    }

    public function getAllInvoiceById($id)
    {
        $invoice = $this->with(['category' => function ($category) {
            $category
                ->select('categories.*', 'users_categories.id as users_categories_id', 'users_categories.address', 'sub_districts.name as sub_district_name')
                ->join("users_categories", 'users_categories.category_id', '=', 'categories.id')
                ->join("sub_districts", 'sub_districts.id', '=', 'users_categories.sub_district_id');
        }])
            ->where('user_id', $id)
            ->orderBy('created_at')
            ->get();


        return $invoice;
    }

    public function allUserForInvoicePaidAndUnpaid($pemungut_id)
    {
        $usersPaid = User::withCount(['invoices as invoiceCount' => function ($query) {
            $query->where('status', 1);
        }])
            ->whereIn('id', function ($query) use ($pemungut_id) {
                $query->select('user_id')
                    ->distinct()
                    ->from('users_categories')
                    ->where('pemungut_id', $pemungut_id);
            })
            ->groupBy('id')
            ->having('invoiceCount', '>', 0)
            ->get();


        $usersUnpaid = User::withCount(['invoices as invoiceCount' => function ($query) {
            $query->where('status', 0);
        }])
            ->whereIn('id', function ($query) use ($pemungut_id) {
                $query->select('user_id')
                    ->distinct()
                    ->from('users_categories')
                    ->where('pemungut_id', $pemungut_id);
            })
            ->groupBy('id')
            ->having('invoiceCount', '>', 0)
            ->get();

        return [
            'users.paid' => [
                'records' => $usersPaid,
                'count' => $usersPaid->sum('invoiceCount'),
            ],
            'users.unpaid' => [
                'records' => $usersUnpaid,
                'count' => $usersUnpaid->sum('invoiceCount'),
            ],
        ];
    }
}
