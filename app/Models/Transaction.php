<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function sumTransactionByType()
    {
        $transactions = $this->selectRaw('type, SUM(price) as total')->groupBy('type')->get();
        $income = collect($transactions)->map(function ($item) {
            return [strtolower($item['type']) => (int)$item['total']];
        })->collapse();

        return $income;
    }

    public function generateReferenceAndTransactionNumber(){
        $reference_number = 'REF-' . date('Ymd') . '-' . substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 4) . '-' . substr(str_shuffle('1234567890'), 0, 7);
        $transaction_number = 'TRAN-' . date('Ymd') . '-' . substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5) . '-' . substr(str_shuffle('1234567890'), 0, 7);

        return [
            'reference_number' => $reference_number,
            'transaction_number' => $transaction_number,
        ];
    }

    public function storeTransactionInvoice($data){
        // $invoice_id = $data['invoice_id'];
        // $invoice = Invoice::whereIn('id', $invoice_id)->get();

        $number = $this->generateReferenceAndTransactionNumber();

        $transactions = $this->create([
            'price' => $data['total_amount'],
            'status' => 1,
            'date' => now(),
            'reference_number' => $number['reference_number'],
            'transaction_number' => $number['transaction_number'],
            'user_id' => $data['masyarakat_id'],
            'pemungut_id' => $data['pemungut_id'],
            'sub_district_id' => $data['sub_district_id'],
            'category_id' => $data['category_id'],
            'type' => $data['type'],
        ]);

        return $transactions;
    }
}
