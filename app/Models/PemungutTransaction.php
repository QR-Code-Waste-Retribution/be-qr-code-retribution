<?php

namespace App\Models;

use App\Http\Resources\DepositPemungutResource;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

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

    public function getDepositPemungut()
    {
        $deposit = $this->select("*"
            // DB::raw("
            //     CASE
            //         WHEN status = 0 THEN 'not_yet_deposited'
            //         WHEN status = 1 THEN 'already_deposited'
            //     END as status_deposit,
            //     SUM(total) as total_amount, 
            // "),
            // DB::raw('MAX(updated_at) as updated_at')
        )
            ->with(['masyarakat_transactions'])
            ->whereIn('pemungut_id', function ($query) {
                $query->select('id')
                    ->from('users')
                    ->where('district_id', auth()->user()->district_id);
            })
            ->whereRaw('MONTH(pemungut_transactions.updated_at) = MONTH(CURRENT_DATE())')
            // ->groupBy('pemungut_transactions.status')
            ->get();

        return $deposit;
        return collect($deposit)->mapWithKeys(function ($item) {
            return [$item['status_deposit'] => [
                'total' => $item['total_amount'],
                'date' =>  date('d F Y', strtotime($item['updated_at']))
            ]];
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

    public function getAllTransaction($sub_district, $search)
    {
        $pemungut_transactions = User::where('role_id', 2)
            ->with(['pemungut_transactions' => function ($query) {
                $query->selectRaw('id, pemungut_id, date, status, SUM(total) as total')
                    ->where(DB::raw('MONTH(pemungut_transactions.date)'), '=', DB::raw('MONTH(CURRENT_DATE())'))
                    ->groupBy('pemungut_id', 'status', 'date', 'id')
                    ->union(
                        PemungutTransaction::selectRaw('id, pemungut_id, date, status, SUM(total) as total')
                            ->where(DB::raw('MONTH(pemungut_transactions.date)'), '<', DB::raw('MONTH(CURRENT_DATE())'))
                            ->where('status', 0)
                            ->groupBy('pemungut_id', 'status', 'date', 'id')
                    );
            },  'sub_district'])
            ->where('district_id', auth()->user()->district_id)
            ->where(function (Builder $query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });

        if ($sub_district && $sub_district != 'all') {
            $pemungut_transactions = $pemungut_transactions->where('sub_district_id', $sub_district);
        }

        $pemungut_transactions = $pemungut_transactions->paginate(10);

        return $pemungut_transactions;
    }

    public function show($id)
    {
        $data =  User::where('id', $id)->with(['pemungut_transactions' => function ($query) {
            $query->selectRaw('id, pemungut_id, date, status, SUM(total) as total')
                ->where(DB::raw('MONTH(pemungut_transactions.date)'), '=', DB::raw('MONTH(CURRENT_DATE())'))
                ->groupBy('pemungut_id', 'status', 'date', 'id')
                ->orderBy('pemungut_transactions.date', 'ASC')
                ->union(
                    PemungutTransaction::selectRaw('id, pemungut_id, date, status, SUM(total) as total')
                        ->where(DB::raw('MONTH(pemungut_transactions.date)'), '<', DB::raw('MONTH(CURRENT_DATE())'))
                        ->where('status', 0)
                        ->groupBy('pemungut_id', 'status', 'date', 'id')
                        ->orderBy('pemungut_transactions.date', 'ASC')
                );
        }, 'sub_district'])->first();

        $data['total'] = collect($data['pemungut_transactions'])->sum('total');
        $data['transaction_status'] = collect($data['pemungut_transactions'])->pluck('status')[0];
        $data['transaction_id'] = collect($data['pemungut_transactions'])->pluck('id');

        if (count($data['pemungut_transactions']) >= 2) {
            $date = collect($data['pemungut_transactions'])
                ->reverse()
                ->pluck('date')
                ->map(function ($item) {
                    return ucfirst(date('F Y', strtotime($item)));
                });
            $data['transaction_date_in_arreas'] = $date->first() . ' - ' . $date->last();
        } elseif (count($data['pemungut_transactions']) == 1) {
            $data['transaction_date_in_arreas'] = date('F Y', strtotime(collect($data['pemungut_transactions'][0]['date'])->first()));
        } else {
            $data['transaction_date_in_arreas'] = 'Tidak Ada';
        }

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
}
