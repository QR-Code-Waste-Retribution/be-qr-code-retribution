<?php

namespace App\Models;

use App\Http\Resources\DepositPemungutResource;
use App\Http\Resources\PemungutTransactionResource;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class PemungutTransaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pemungut()
    {
        return $this->belongsTo(User::class);
    }

    public function masyarakat_transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public static function getHistoryTransactionOfPemungut($pemungut_id)
    {

        $month = Carbon::now()->format('Y-m');

        $pemungut_transactions = self::where('pemungut_id', $pemungut_id)->with('masyarakat_transactions')
            ->whereRaw("DATE_FORMAT(updated_at, '%Y-%m') = '$month'")
            ->union(
                self::where('pemungut_id', $pemungut_id)->with('masyarakat_transactions')
                    ->whereRaw("DATE_FORMAT(updated_at, '%Y-%m') < '$month'")
                    ->where('status', 0)
            )
            ->orderBy('created_at', 'DESC')
            ->get();

        $date_transactions = $pemungut_transactions->pluck('date')->unique()->sort(function ($a, $b) {
            $monthA = Carbon::createFromFormat('F Y', $a)->format('m');
            $monthB = Carbon::createFromFormat('F Y', $b)->format('m');

            return $monthA <=> $monthB;
        })->values();

        $masyarakat_transactions = $pemungut_transactions->pluck('masyarakat_transactions')->flatten();


        $sumByStatus = $pemungut_transactions->groupBy('status')->map(function ($group) {
            return $group->pluck('masyarakat_transactions')->flatten()->sum('price');
        });

        return [
            'deposits' => PemungutTransactionResource::collection($masyarakat_transactions),
            'deposit_status' => [
                'already_deposited' => $sumByStatus[1] ?? 0,
                'not_yet_deposited' => $sumByStatus[0] ?? 0,
            ],
            'deposit_arreas' => $date_transactions->first() . ' - ' . $date_transactions->last(),
        ];
    }

    public function getDepositAdditionalDataByDistrictId()
    {
        $deposit = $this->select([
            DB::raw("
                CASE
                    WHEN pemungut_transactions.status = 0 THEN 'not_yet_deposited'
                    WHEN pemungut_transactions.status = 1 THEN 'already_deposited'
                END as status_deposit"),
            DB::raw("SUM(masyarakat_transactions.price) as total_amount"),
            DB::raw("MAX(pemungut_transactions.updated_at) as updated_at"),
        ])
            ->join('masyarakat_transactions', 'pemungut_transactions.id', '=', 'masyarakat_transactions.pemungut_transaction_id')
            ->join('invoice', 'masyarakat_transactions.id', '=', 'invoice.masyarakat_transaction_id')
            ->whereIn('invoice.category_id', function ($query) {
                $query->select('id')
                    ->from('categories')
                    ->whereIn('type', ["PACKET", "UNIT", "DAY"])
                    ->where('district_id', auth()->user()->district_id);
            })
            ->whereIn('pemungut_transactions.pemungut_id', function ($query) {
                $query->select('id')
                    ->from('users')
                    ->where('role_id', 2)
                    ->where('district_id', auth()->user()->district_id);
            })
            ->whereRaw('MONTH(pemungut_transactions.updated_at) = MONTH(CURRENT_DATE())')
            ->groupBy('pemungut_transactions.status')
            ->get();

        $response = [
            'already_deposited' => [
                'total' => 0,
                'date' =>  null,
            ],
            'not_yet_deposited' => [
                'total' => 0,
                'date' =>  null,
            ],
        ];

        foreach ($deposit as $item) {
            $response[$item['status_deposit']] = [
                'total' => $item['total_amount'],
                'date' =>  date('d F Y', strtotime($item['updated_at']))
            ];
        }

        return $response;
    }

    public function getDepositMonthlyDataByDistrictId()
    {
        $deposit = $this->select([
            DB::raw("
                CASE
                    WHEN pemungut_transactions.status = 0 THEN 'not_yet_deposited'
                    WHEN pemungut_transactions.status = 1 THEN 'already_deposited'
                END as status_deposit"),
            DB::raw("SUM(masyarakat_transactions.price) as total_amount"),
            DB::raw("MAX(pemungut_transactions.updated_at) as updated_at"),
        ])
            ->join('masyarakat_transactions', 'pemungut_transactions.id', '=', 'masyarakat_transactions.pemungut_transaction_id')
            ->join('invoice', 'masyarakat_transactions.id', '=', 'invoice.masyarakat_transaction_id')
            ->whereIn('invoice.category_id', function ($query) {
                $query->select('id')
                    ->from('categories')
                    ->whereIn('type', ['MONTH'])
                    ->where('district_id', auth()->user()->district_id);
            })
            ->whereIn('pemungut_transactions.pemungut_id', function ($query) {
                $query->select('id')
                    ->from('users')
                    ->where('role_id', 2)
                    ->where('district_id', auth()->user()->district_id);
            })
            ->whereRaw('MONTH(pemungut_transactions.updated_at) = MONTH(CURRENT_DATE())')
            ->groupBy('pemungut_transactions.status')
            ->get();

        return collect($deposit)->mapWithKeys(function ($item) {
            return [
                $item['status_deposit'] => [
                    'total' => $item['total_amount'],
                    'date' =>  date('d F Y', strtotime($item['updated_at']))
                ]
            ];
        })->toArray();
    }

    public function getDepositPemungutById($pemungut_id)
    {
        $deposit = $this->selectRaw('id, pemungut_id, date, status, SUM(total) as total')
            ->where('pemungut_id', $pemungut_id)
            ->where(DB::raw('MONTH(pemungut_transactions.date)'), '=', DB::raw('MONTH(CURRENT_DATE())'))
            ->groupBy('pemungut_id', 'status', 'date', 'id')
            ->union(
                PemungutTransaction::selectRaw('id, pemungut_id, date, status, SUM(total) as total')
                    ->where('pemungut_id', $pemungut_id)
                    ->where(DB::raw('MONTH(pemungut_transactions.date)'), '<', DB::raw('MONTH(CURRENT_DATE())'))
                    ->where('status', 0)
                    ->groupBy('pemungut_id', 'status', 'date', 'id')
            )->get();

        return [
            'deposit' => DepositPemungutResource::collection($deposit)
        ];
    }

    public function getPemungutTransactionsByStatus($status)
    {
        return $this->selectRaw('id, pemungut_id, date, status')
            ->where(DB::raw('MONTH(pemungut_transactions.date)'), '<', DB::raw('MONTH(CURRENT_DATE())'))
            ->where('status', $status)
            ->groupBy('pemungut_id', 'status', 'date', 'id');
    }

    public function getAllTransaction($sub_district, $search)
    {
        $pemungut_transactions = User::where('role_id', 2)
            ->with([
                'pemungut_transactions' => function ($query) {
                    $query->selectRaw('id, pemungut_id, date, status')
                        ->where('status', 0)
                        ->where(DB::raw('MONTH(pemungut_transactions.updated_at)'), '=', DB::raw('MONTH(CURRENT_DATE())'))
                        ->groupBy('pemungut_id', 'status', 'date', 'id')
                        ->union($this->getPemungutTransactionsByStatus(1));
                },
                'pemungut_transactions.masyarakat_transactions:id,pemungut_transaction_id,price', // Include the masyarakat_transaction relationship
                'sub_district'
            ])
            ->where('district_id', auth()->user()->district_id)
            ->where(function (Builder $query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->withCount(['pemungut_transactions' => function ($query) {
                $query->where('status', 0);
            }]);

        if ($sub_district && $sub_district != 'all') {
            $pemungut_transactions = $pemungut_transactions->where('sub_district_id', $sub_district);
        }
        $pemungut_transactions = $pemungut_transactions
            ->orderBy('pemungut_transactions_count', 'desc');
        $pemungut_transactions = $pemungut_transactions->paginate(10);

        return $pemungut_transactions;
    }

    public function show($id)
    {
        $data =  User::where('id', $id)->with([
            'pemungut_transactions' => function ($query) {
                $query->selectRaw('id, pemungut_id, date, status, updated_at')
                    ->groupBy('pemungut_id', 'status', 'date', 'id')
                    ->orderBy('pemungut_transactions.created_at', 'ASC');
            },
            'pemungut_transactions.masyarakat_transactions:id,price,pemungut_transaction_id,user_id,created_at', // Include the masyarakat_transaction relationship
            'pemungut_transactions.masyarakat_transactions.user:id,name,gender', // Include the masyarakat_transaction relationship
            'pemungut_transactions.masyarakat_transactions.invoice:id,masyarakat_transaction_id,category_id,price', // Include the masyarakat_transaction invoice relationship
            'pemungut_transactions.masyarakat_transactions.invoice.category:id,name,type', // Include the masyarakat_transaction invoice relationship
            'sub_district',
        ])->first();


        foreach ($data['pemungut_transactions'] as $item) {
            if (!$item->status) {
                $data['transaction_date_in_arreas'] .= date('F Y,', strtotime($item->updated_at));
            }
        }

        $arreas_transactions = Str::of($data['transaction_date_in_arreas'])->rtrim(',')->explode(',');
        $data['transaction_date_in_arreas'] = $arreas_transactions->first() . ' - ' . $arreas_transactions->last();

        return $data;
    }

    public static function getRangeArreas($data)
    {
        $str = '';
        if (count($data) >= 2) {
            $date = collect($data)
                ->reverse()
                ->pluck('date')
                ->map(function ($item) {
                    return ucfirst(date('F Y', strtotime($item)));
                });
            if ($date->first() == $date->last())
                $str = $date->first();
            else
                $str = $date->first() . ' - ' . $date->last();
        } elseif (count($data) == 1) {
            $str = date('F Y', strtotime(collect($data[0]['date'])->first()));
        } else {
            $str = 'Tidak Ada';
        }

        return $str;
    }


    public function getTotal($data)
    {
        return collect($data)->sum('total');
    }

    public function getStatus($data)
    {
        return collect($data['pemungut_transactions'])->pluck('status')[0];
    }

    public function getTransactionId($data)
    {
        return collect($data['pemungut_transactions'])->pluck('id');
    }

    public function getTargetIncome()
    {
        return Invoice::select(DB::raw('SUM(price) as target'))
            ->where(DB::raw('MONTH(invoice.created_at)'), '=', DB::raw('MONTH(CURRENT_DATE())'))
            ->get();
    }

    public function getIncomeData()
    {
        $income = DB::table(function ($subquery) {
            $subquery->selectRaw("DATE_FORMAT(pt.updated_at, '%b') AS month_name, SUM(mt.price) AS monthly_income_count")
                ->from('pemungut_transactions as pt')
                ->join('masyarakat_transactions as mt', 'mt.pemungut_transaction_id', '=', 'pt.id')
                ->where('pt.status', 1)
                ->whereIn('pt.pemungut_id', function ($query) {
                    $query->select('id')
                        ->from('users')
                        ->where('district_id', 1)
                        ->where('role_id', 2);
                })
                ->whereBetween('pt.updated_at', [
                    DB::raw('DATE_SUB(CURRENT_DATE, INTERVAL 12 MONTH)'),
                    DB::raw('CURRENT_DATE')
                ])
                ->groupBy('month_name', DB::raw('MONTH(pt.updated_at)'))
                ->orderBy(DB::raw('MONTH(pt.updated_at)'));
        }, 'monthly_incomes')
            ->select('month_name', 'monthly_income_count')
            ->get();

        return [
            'months' => $income->pluck('month_name'),
            'income' => $income->pluck('monthly_income_count'),
        ];
    }
}
