<?php

namespace App\Models;

use App\Http\Resources\DokuFormat\DokuCheckoutResource;
use App\Http\Resources\DokuFormat\DokuDirectApiResource;
use App\Http\Resources\FInvoiceResource;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\TransactionResource;
use App\Utils\DokuGenerateToken;
use App\Utils\TimeCheck;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    use HasFactory;

    protected $table = "masyarakat_transactions";

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function pemungut()
    {
        return $this->belongsTo(User::class, 'pemungut_id', 'id');
    }

    public function invoice()
    {
        return $this->hasMany(Invoice::class, 'masyarakat_transaction_id', 'id');
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

    public function checkout()
    {
        return $this->hasOne(DokuCheckout::class, 'masyarakat_transaction_id', 'id');
    }

    public function directApi()
    {
        return $this->hasOne(DokuDirectApi::class, 'masyarakat_transaction_id', 'id');
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

    public function getTransactionWithInvoiceByMasyarakat($id)
    {
        $transaction = $this->where('id', $id)->with(['invoice'])->first();

        if (!$transaction) {
            throw new Exception("Transaksi anda tidak ditemukan", 404);
        }

        return $transaction;
    }

    public function getAllNonCashTransaction()
    {
        return SubDistrict::select(['id', 'name'])
            ->with(['transactions' => function ($query) {
                $query->selectRaw('sub_district_id, SUM(price) as total')
                    ->where('type', 'NONCASH')
                    ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE())')
                    ->groupBy('sub_district_id');
            }])
            ->where('district_id', auth()->user()->district_id)
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
            ->whereRaw('MONTH(date) = MONTH(CURRENT_DATE())')
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


        $invoice_parents = Invoice::whereIn('id', $parentsArray)->get();

        foreach ($invoice_parents as $item) {
            $item['price'] *= $variantsCount[$item->id];
            $item['variants_count'] = $variantsCount[$item->id];
        }

        $pemungutTransaction = PemungutTransaction::updateOrCreate([
            'pemungut_id' => $data['pemungut_id'],
            'status' => 0,
            'date' => date('F Y', strtotime(now())),
        ], [
            'status' => 0,
        ]);


        $transactions = $this->create([
            'price' => $data['total_amount'],
            'date' => now(),
            'status' => '1',
            'type' => 'CASH',
            'invoice_number' => 'INV-' . time(),
            'reference_number' => $numberRefAndTran['reference_number'],
            'transaction_number' => $numberRefAndTran['transaction_number'],
            'user_id' => $masyarakat_id,
            'pemungut_id' => $data['pemungut_id'],
            'pemungut_transaction_id' => $pemungutTransaction->id,
            'sub_district_id' => $data['sub_district_id'],
        ]);

        $invoice = Invoice::whereIn('id', $invoices_id);
        $invoice->update(['status' => 1, 'masyarakat_transaction_id' => $transactions->id]);

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

        $pemungutTransaction = PemungutTransaction::updateOrCreate([
            'pemungut_id' => $data['pemungut_id'],
            'status' => 0,
            'date' => date('F Y', strtotime(now())),
        ], [
            'status' => 0,
        ]);


        $transaction = $this->create([
            'price' => $data['total_amount'],
            'date' => now(),
            'status' => '1',
            'type' => 'CASH',
            'invoice_number' => 'INV-' . time(),
            'reference_number' => $numberRefAndTran['reference_number'],
            'transaction_number' => $numberRefAndTran['transaction_number'],
            'user_id' => $data['pemungut_id'],
            'pemungut_id' => $data['pemungut_id'],
            'sub_district_id' => $data['sub_district_id'],
            'pemungut_transaction_id' => $pemungutTransaction->id,
        ]);

        $invoice = Invoice::create([
            'category_id' => $category_id,
            'price' => $data['total_amount'],
            'user_id' => null,
            'uuid_user' => null,
            'masyarakat_transaction_id' => $transaction->id,
            'status' => 1,
        ]);

        return [
            'transaction' => new TransactionResource($transaction),
            'invoice' => InvoiceResource::collection(collect([$invoice])),
        ];
    }

    public function storeTransactionInvoiceNonCash($data)
    {
        $line_items = $data['line_items'];
        $masyarakat_id = $data['masyarakat_id'];

        $masyarakat = User::find($masyarakat_id);

        $checkTransaction = $this->where('user_id', $masyarakat_id)
            ->where('status', 0)
            ->where('type', "NONCASH")
            ->orderBy('created_at', 'DESC')
            ->first();

        if ($checkTransaction) {
            if ($data['method']['payments'] == "CHECKOUT") {
                if ($checkout = $checkTransaction->checkout) {
                    $expired_date = $checkout->payment_expired_date;

                    if (TimeCheck::checkExpiredDate($expired_date)) {
                        return [
                            'transaction' => new DokuCheckoutResource($checkTransaction),
                            'message' => 'Silahkan lanjutkan pembayaran sesuai metode yang anda pilih!!',
                            'code' => 200,
                        ];
                    }
                }
            }
            if ($data['method']['payments'] == "VIRTUAL_ACCOUNT") {
                if ($direct_api = $checkTransaction->directApi) {
                    $expired_date = $direct_api->expired_date;

                    if (TimeCheck::checkExpiredDate($expired_date)) {
                        return [
                            'transaction' => new DokuDirectApiResource($checkTransaction),
                            'message' => 'Silahkan lanjutkan pembayaran sesuai metode yang anda pilih!!',
                            'code' => 200,
                        ];
                    }
                }
            }
        }

        $numberRefAndTran = $this->generateReferenceAndTransactionNumber();

        $doku = new DokuGenerateToken($data['method'], $data['uuid']);
        $token = $doku->generateToken($line_items, $masyarakat, $data['total_amount']);

        $transactions = $this->create([
            'price' => $token['transaction']['total_amount'],
            'date' => now(),
            'status' => '0',
            'type' => 'NONCASH',
            'invoice_number' => $token['transaction']['invoice_number'],
            'reference_number' => $numberRefAndTran['reference_number'],
            'transaction_number' => $numberRefAndTran['transaction_number'],
            'user_id' => $masyarakat_id,
            'pemungut_id' => $data['pemungut_id'],
            'sub_district_id' => $data['sub_district_id'],
        ]);

        $invoices_id = collect($line_items)->pluck('invoice_id');

        Invoice::whereIn('id', $invoices_id)->update(['masyarakat_transaction_id' =>  $transactions->id]);

        if ($data['method']['payments'] == 'VIRTUAL_ACCOUNT') {
            $virtual_account_info = $token['data']['virtual_account_info'];
            $order = $token['data']['order'];

            DokuDirectApi::create([
                'invoice_number' => $order['invoice_number'],
                'bank_name' => $token['data']['bank']['bank_name']['full_name'],
                'bank_name_short' => $token['data']['bank']['bank_name']['short_name'],
                'virtual_account_number' => $virtual_account_info['virtual_account_number'],
                'how_to_pay_page' => $virtual_account_info['how_to_pay_page'],
                'how_to_pay_api' => $virtual_account_info['how_to_pay_api'],
                'created_date' => $virtual_account_info['created_date'],
                'expired_date' => $virtual_account_info['created_date'],
                'created_date_utc' => $virtual_account_info['created_date_utc'],
                'expired_date_utc' => $virtual_account_info['expired_date_utc'],
                'masyarakat_transaction_id' => $transactions->id
            ]);
        }

        // if ($data['method']['payments'] == 'CHECKOUT') {
        //     $order = $token['data']['response']['order'];
        //     $payment = $token['data']['response']['payment'];
        //     $uuid = $token['data']['response']['uuid'];

        //     DokuCheckout::create([
        //         'currency' => $order['currency'],
        //         'session_id' => $order['session_id'],
        //         'payment_method_types' => json_encode($payment['payment_method_types']),
        //         'payment_due_date' => $payment['payment_due_date'],
        //         'payment_token_id' => $payment['token_id'],
        //         'payment_url' => $payment['url'],
        //         'payment_expired_date' => $payment['expired_date'],
        //         'uuid' => $uuid,
        //         'masyarakat_transaction_id' => $transactions->id
        //     ]);
        // }

        $token['data']['merchant.transaction_id'] = $transactions['id'];

        return [
            'transaction' => $token['data'],
            'message' => 'Silahkan lanjutkan pembayaran sesuai metode yang anda pilih!!',
            'code' => $token['code'],
        ];
    }

    public function storeTransactionInvoiceNonCashDirectApi($data)
    {
        $line_items = $data['line_items'];
        $masyarakat_id = $data['masyarakat_id'];

        $masyarakat = User::find($masyarakat_id);

        $checkTransaction = $this->where('user_id', $masyarakat_id)
            ->where('status', 0)
            ->where('type', "NONCASH")
            ->orderBy('created_at', 'DESC')
            ->first();

        if ($checkTransaction) {
            if ($direct_api = $checkTransaction->directApi) {
                $expired_date = $direct_api->expired_date;

                if (TimeCheck::checkExpiredDate($expired_date)) {
                    return [
                        'transaction' => new DokuDirectApiResource($checkTransaction),
                        'message' => 'Silahkan lanjutkan pembayaran sesuai metode yang anda pilih!!',
                        'code' => 200,
                    ];
                }

                $checkTransaction->status = 3;
                $checkTransaction->save();
            }
        }


        $numberRefAndTran = $this->generateReferenceAndTransactionNumber();

        $doku = new DokuGenerateToken($data['method'], $data['uuid']);
        $token = $doku->generateToken($line_items, $masyarakat, $data['total_amount']);

        $transactions = $this->create([
            'price' => $token['transaction']['total_amount'],
            'date' => now(),
            'status' => '0',
            'type' => 'NONCASH',
            'invoice_number' => $token['transaction']['invoice_number'],
            'reference_number' => $numberRefAndTran['reference_number'],
            'transaction_number' => $numberRefAndTran['transaction_number'],
            'user_id' => $masyarakat_id,
            'pemungut_id' => $data['pemungut_id'],
            'sub_district_id' => $data['sub_district_id'],
        ]);

        $invoices_id = collect($line_items)->pluck('invoice_id');

        Invoice::whereIn('id', $invoices_id)->update(['masyarakat_transaction_id' =>  $transactions->id]);

        $virtual_account_info = $token['data']['virtual_account_info'];
        $order = $token['data']['order'];

        DokuDirectApi::create([
            'invoice_number' => $order['invoice_number'],
            'bank_name' => $order['bank']['full_name'],
            'bank_name_short' => $order['bank']['short_name'],
            'virtual_account_number' => $virtual_account_info['virtual_account_number'],
            'how_to_pay_page' => $virtual_account_info['how_to_pay_page'],
            'how_to_pay_api' => $virtual_account_info['how_to_pay_api'],
            'created_date' => $virtual_account_info['created_date'],
            'expired_date' => $virtual_account_info['created_date'],
            'created_date_utc' => $virtual_account_info['created_date_utc'],
            'expired_date_utc' => $virtual_account_info['expired_date_utc'],
            'masyarakat_transaction_id' => $transactions->id
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
        for ($i = 11; $i >= 0; $i--) {
            $month_no = date('m', strtotime("-{$i} months"));
            $month_name = $this->getMonthName($month_no);
            $month_array[$month_no] = $month_name;
        }
        return $month_array;
    }

    public function getMonthlyIncomeCountPayment($month)
    {
        $current_year = date('Y');
        $incomes = $this->whereMonth('date', $month)
            ->whereIn('sub_district_id', function ($query) {
                $query->select('id')
                    ->from('sub_districts')
                    ->where('district_id', 1);
            })
            ->where('status', 1)
            ->whereYear('date', $current_year)
            ->sum('price');
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
        $transactions = $this->select('type')
            ->selectRaw('SUM(price) as total')
            ->selectRaw('COUNT(type) as count')
            ->whereIn('user_id', function ($query) {
                $query->select('id')
                    ->from('users')
                    ->where('role_id', 1)
                    ->where('district_id', auth()->user()->district_id);
            })
            ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE())')
            ->groupBy('type', 'created_at')
            ->get();

        $income = collect($transactions)->map(function ($item) {
            return [strtolower($item['type']) => (int)$item['total'] - ($item['count'] * 3500)];
        })->collapse();

        return $income;
    }

    public function updateTransactionAndInvoiceNonCash($invoice_id, $transaction_id)
    {
        Invoice::whereIn('id', $invoice_id)->update(['status' => 1]);

        $transaction = Transaction::find($transaction_id);
        $transaction->status = 1;
        $transaction->save();

        return $transaction;
    }

    public function nonCashTransactionBySubDistrictId($id)
    {
        return $this
            ->where('type', 'NONCASH')
            ->with(
                [
                    'checkout:id,payment_method_types',
                    'directApi:masyarakat_transaction_id,bank_name,bank_name_short',
                    'user:id,name'
                ]
            )
            ->where('sub_district_id', $id)
            ->paginate(10);
    }

    public function transactionQRISByDistrict()
    {
        return $this->with(['checkout'])
            ->whereHas('checkout')
            ->where('status', 1)
            ->where(DB::raw('MONTH(masyarakat_transactions.created_at)'), '=', DB::raw('MONTH(CURRENT_DATE())'))
            ->get();
    }

    public function transactionVirtualAccountByDistrict()
    {
        return $this->with(['directApi'])
            ->whereHas('directApi')
            ->where('status', 1)
            ->where(DB::raw('MONTH(masyarakat_transactions.created_at)'), '=', DB::raw('MONTH(CURRENT_DATE())'))
            ->get();
    }
}
