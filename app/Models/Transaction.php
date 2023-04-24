<?php

namespace App\Models;

use App\Http\Resources\DokuFormat\LineItemOrderDokuResource;
use App\Utils\DokuGenerateToken;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    use HasFactory;


    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function pemungut()
    {
        return $this->belongsTo(User::class, 'pemungut_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sub_district()
    {
        return $this->belongsTo(SubDistrict::class);
    }

    public static function getAllById($id)
    {
        return self::all()->where('user_id', $id);
    }

    public static function getHistoryTransactionOfPemungut($pemungut_id)
    {
        return self::where('pemungut_id', $pemungut_id)->get();
    }

    public function getAllNonCashTransaction()
    {
        return $this
            ->selectRaw('sub_district_id, SUM(price) as total')
            ->with(['sub_district:id,name'])
            ->whereIn('sub_district_id', function ($query) {
                $query->select('id')
                    ->from('sub_districts')
                    ->where('district_id', auth()->user()->district_id);
            })
            ->where('type', 'NONCASH')
            ->groupBy('sub_district_id')
            ->get();
    }

    public function getAllTransaction()
    {
        $data = $this
            ->selectRaw('type, sub_district_id, SUM(price) as total')
            ->with(['sub_district:id,name'])
            ->whereIn('sub_district_id', function ($query) {
                $query->select('id')
                    ->from('sub_districts')
                    ->where('district_id', auth()->user()->district_id);
            })
            ->groupBy('sub_district_id', 'type')
            ->get();



        $result = collect($data)
            ->groupBy('sub_district_id')
            ->map(function ($items, $key) {
                $cash = $items->where('type', 'CASH')->sum('total');
                $noncash = $items->where('type', 'NONCASH')->sum('total');
                return [
                    "sub_district_id" => $key,
                    "sub_district" => $items[0]['sub_district'],
                    "total" => $cash + $noncash,
                    "cash" => $cash,
                    "noncash" => $noncash,
                ];
            })
            ->values();

        $perPage = 10;
        $page = request()->get('page', 1);
        $offset = ($page - 1) * $perPage;

        $paginatedData = $result->slice($offset, $perPage)->all();

        $paginatedCollection = new \Illuminate\Pagination\LengthAwarePaginator(
            $paginatedData,
            count($result),
            $perPage,
            $page
        );

        return $paginatedCollection;
    }


    public function generateReferenceAndTransactionNumber()
    {
        $reference_number = 'REF-' . date('Ymd') . '-' . substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 4) . '-' . substr(str_shuffle('1234567890'), 0, 7);
        $transaction_number = 'TRAN-' . date('Ymd') . '-' . substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5) . '-' . substr(str_shuffle('1234567890'), 0, 7);

        return [
            'reference_number' => $reference_number,
            'transaction_number' => $transaction_number,
        ];
    }

    public function storeTransactionInvoice($data)
    {
        $invoice_id = $data['invoice_id'];
        $masyarakat_id = $data['masyarakat_id'];

        $invoice =  LineItemOrderDokuResource::collection(Invoice::whereIn('id', $invoice_id)->with('category:id,name')->get())->toArray($data);
        $masyarakat = User::find($masyarakat_id);

        $doku = new DokuGenerateToken($data['method'], $data['uuid']);
        $token = $doku->generateToken($invoice, $masyarakat);

        return $token;
    }



    public function getMonthName($number_of_month)
    {
        return date('F', strtotime("{$number_of_month}/1/2000"));
    }

    public function getMonth()
    {
        $month_array = array();
        for ($i = 4; $i >= 0; $i--) {
            $month_no = date('m', strtotime("-{$i} months"));
            $month_name = $this->getMonthName($month_no);
            $month_array[$month_no] = $month_name;
        }
        return $month_array;
    }

    public function getMonthlyIncomeCountPayment($month)
    {
        $current_year = date('Y');
        $incomes = $this->whereMonth('date', $month)->whereYear('date', $current_year)->sum('price');
        return $incomes;
    }

    public function getIncomeData()
    {
        $monthly_income_count_array = array();
        $month_array = $this->getMonth();
        $month_name_array = array_values($month_array);
        if (!empty($month_array)) {
            foreach ($month_array as $month_no => $month_name) {
                $monthly_income_count = $this->getMonthlyIncomeCountPayment($month_no);
                $monthly_income_count_array[] = $monthly_income_count;
            }
        }
        return [
            'income' => $monthly_income_count_array,
            'months' => $month_name_array,
        ];
    }

    public function sumTransactionByType()
    {
        $transactions = $this->selectRaw('type, SUM(price) as total')
            ->where(DB::raw('MONTH(transactions.date)'), '=', DB::raw('MONTH(CURRENT_DATE())'))
            ->groupBy('type', 'date')->get();
        $income = collect($transactions)->map(function ($item) {
            return [strtolower($item['type']) => (int)$item['total']];
        })->collapse();

        return $income;
    }
}
