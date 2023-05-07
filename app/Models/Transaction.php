<?php

namespace App\Models;

use App\Http\Resources\DokuFormat\LineItemOrderDokuResource;
use App\Http\Resources\FInvoiceResource;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\TransactionResource;
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
        $transactions = self::where('pemungut_id', $pemungut_id)
            ->orderBy('created_at', 'DESC')
            ->get();

        $filteredTransactions = $transactions->where('created_at', '>=', now()->startOfMonth());
        $totalPrice = $filteredTransactions->sum('price');
        return [
            'transaction' => TransactionResource::collection($transactions),
            'total_amount' => $totalPrice,
        ];
    }

    public static function getHistoryTransactionOfMasyarakat($masyarakat_id)
    {
        return self::where('user_id', $masyarakat_id)->orderBy('created_at', "DESC")->get();
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

    public function storeTransactionInvoiceCash($data)
    {
        $invoices = $data['invoices_id'];

        $parentsArray = [];
        $variantsCount = [];

        $invoices_id = [];
        foreach ($invoices as $invoice) {
            $parentsArray[] = $invoice['parents'];
            $variantsCount[$invoice['parents']] = count($invoice['variants']) + 1;

            $invoices_id[] = $invoice['parents'];
            $invoices_id = array_merge($invoices_id, $invoice['variants']);
        }

        $invoices_id = array_filter($invoices_id, 'is_int');
        $invoices_id = array_values($invoices_id);

        $masyarakat_id = $data['masyarakat_id'];
        $numberRefAndTran = $this->generateReferenceAndTransactionNumber();

        $invoice = Invoice::whereIn('id', $invoices_id);
        $invoice->update(['status' => 1]);

        $invoice_parents = Invoice::whereIn('id', $parentsArray)->get();

        foreach ($invoice_parents as $item) {
            $item['price'] *= $variantsCount[$item->id];
            $item['variants_count'] = $variantsCount[$item->id];
        }

        $transactions = $this->create([
            'price' => $data['total_amount'],
            'date' => now(),
            'status' => '1',
            'type' => 'CASH',
            'reference_number' => $numberRefAndTran['reference_number'],
            'transaction_number' => $numberRefAndTran['transaction_number'],
            'user_id' => $masyarakat_id,
            'pemungut_id' => $data['pemungut_id'],
            'category_id' => 1,
            'sub_district_id' => $data['sub_district_id'],
        ]);

        return [
            'transaction' => new TransactionResource($transactions),
            'invoice' => FInvoiceResource::collection($invoice_parents),
            'message' => 'Silahkan lanjutkan pembayaran sesuai metode yang anda pilih!!',
            'code' => 201,
        ];
    }


    public function storeTransactionAdditionalCash($data)
    {
        $category_id = $data['category_id'];
        $numberRefAndTran = $this->generateReferenceAndTransactionNumber();

        $transactions = $this->create([
            'price' => $data['total_amount'],
            'date' => now(),
            'status' => '1',
            'type' => 'CASH',
            'reference_number' => $numberRefAndTran['reference_number'],
            'transaction_number' => $numberRefAndTran['transaction_number'],
            'user_id' => $data['pemungut_id'],
            'pemungut_id' => $data['pemungut_id'],
            'category_id' => $category_id,
            'sub_district_id' => $data['sub_district_id'],
        ]);

        return [
            'transaction' => new TransactionResource($transactions),
        ];
    }

    public function storeTransactionInvoiceNonCash($data)
    {
        $line_items = $data['line_items'];
        $masyarakat_id = $data['masyarakat_id'];

        $masyarakat = User::find($masyarakat_id);

        $numberRefAndTran = $this->generateReferenceAndTransactionNumber();
        
        $doku = new DokuGenerateToken($data['method'], $data['uuid']);
        $token = $doku->generateToken($line_items, $masyarakat, $data['total_amount']);

        $transactions = $this->create([
            'id' => $token['transaction']['id'],
            'price' => $token['transaction']['total_amount'],
            'date' => now(),
            'status' => '1',
            'type' => 'NONCASH',
            'reference_number' => $numberRefAndTran['reference_number'],
            'transaction_number' => $numberRefAndTran['transaction_number'],
            'user_id' => $masyarakat_id,
            'pemungut_id' => $data['pemungut_id'],
            'category_id' => 1,
            'sub_district_id' => $data['sub_district_id'],
        ]);

        $token['data']['merchant.transaction_id'] = $transactions['id'];


        return [
            'transaction' => $token['data'],
            'message' => 'Silahkan lanjutkan pembayaran sesuai metode yang anda pilih!!',
            'code' => $token['code'],
        ];
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



    public function updateTransactionAndInvoiceNonCash($invoice_id, $transaction_id)
    {
        Invoice::whereIn('id', $invoice_id)->update(['status' => 1]);

        $transaction = Transaction::find($transaction_id);
        $transaction->status = '1';

        return $transaction;
    }

    public function getIncomeTambahanDataByDistrictId()
    {
        return $this->select(
            DB::raw('SUM(transactions.price) as total_amount'),
            DB::raw('MAX(created_at) as updated_at'),
        )
            ->whereIn('category_id', function ($query) {
                $query->select('id')
                    ->from('categories')
                    ->whereIn('type', ['packet', 'unit', 'day'])
                    ->where('district_id', auth()->user()->district_id);
            })
            ->where('status', 1)
            ->first();
    }
}
