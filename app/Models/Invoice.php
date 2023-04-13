<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoice';

    public $invoices_formatted = array();

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
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
            foreach ($this->invoices_formatted as $item) {
                if ($invoice['category_id'] == $item['category_id'] && $invoice['status'] == $item['status']) {
                    $item['price'] += $invoice['price'];
                    $item['date'] =  $item['date'] . ' - ' . date('d F Y', strtotime($invoice['created_at']));
                    return;
                    break;
                } else {
                    $invoice['date'] = date('d F Y', strtotime($invoice['created_at']));
                }
            }
        } else {
            $invoice['date'] = date('d F Y', strtotime($invoice['created_at']));
        }
        array_push($this->invoices_formatted, $invoice);
    }

    public function checkStatusInvoiceAndSubDistrict($invoice)
    {
        if (count($this->invoices_formatted) > 0) {
            foreach ($this->invoices_formatted as $item) {
                if ($invoice['category_id'] == $item['category_id'] && $invoice['status'] == $item['status'] && $invoice['sub_district_id'] == $item['sub_district_id']) {
                    $item['price'] += $invoice['price'];
                    $item['date'] =  $item['date'] . ' - ' . date('d F Y', strtotime($invoice['created_at']));
                    return;
                    break;
                } else {
                    $invoice['date'] = date('d F Y', strtotime($invoice['created_at']));
                }
            }
        } else {
            $invoice['date'] = date('d F Y', strtotime($invoice['created_at']));
        }
        array_push($this->invoices_formatted, $invoice);
    }


    public function getInvoiceById($uuid, $sub_district_id)
    {
        $invoice_user_current_month = Invoice::select('invoice.*', 'users_categories.user_id', 'users_categories.address', 'sub_districts.name as sub_district_name')
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

        $invoice_user_previous_month = Invoice::select('invoice.*', 'users_categories.user_id', 'users_categories.address', 'sub_districts.name as sub_district_name')
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
}
