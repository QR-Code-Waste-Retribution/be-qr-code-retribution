<?php

namespace App\Export;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PaymentExport implements FromCollection, WithHeadings, WithMapping
{
    public $numRows = 0;
    public $type;


    public function __construct($type)
    {
        $this->type = $type; // CASH | NONCASH
    }

    public function collection()
    {
        return Transaction::select(
            'id',
            'reference_number',
            'transaction_number',
            'user_id',
            'pemungut_id',
            'sub_district_id',
            'price',
            'status',
            'created_at'
        )->where('type', $this->type)
            ->whereIn('sub_district_id', function ($query) {
                $query->select('id')->from('sub_districts')->where('district_id', auth()->user()->district_id);
            })
            ->get();
    }

    public function headings(): array
    {
        $headings = [
            '#',
            'Nomor Referensi',
            'Nomor Transaksi',
            'Nama Customer',
            'NIK Customer',
            'Kecamatan',
            'Total Harga',
            'Status',
            'Tanggal Pembayaran',
        ];

        if ($this->type == "CASH") array_splice(
            $headings,
            5,
            0,
            'Nama Pemungut'
        );

        return $headings;
    }

    public function map($item): array
    {
        $values = [
            ++$this->numRows,
            $item->reference_number,
            $item->transaction_number,
            $item->user->name,
            $item->user->nik,
            "Kec. " . $item->sub_district->name,
            $item->price,
            $item->status ? 'Lunas' : 'Belum Lunas',
            $item->created_at,
        ];

        if ($this->type == "CASH") array_splice($values, 5, 0, $item->pemungut->name);

        return $values;
    }
}
