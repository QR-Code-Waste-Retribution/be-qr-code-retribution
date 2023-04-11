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


    public function __construct($type) {
        $this->type = $type;
    }

    public function collection()
    {
        return Transaction::select('id', 'reference_number', 'transaction_number', 'user_id', 'pemungut_id', 'sub_district_id', 'price', 'category_id', 'status', 'created_at')->where('type', $this->type)->get();
    }

    public function headings(): array
    {
        return [
            '#',
            'Nomor Referensi',
            'Nomor Transaksi',
            'Nama Customer',
            'NIK Customer',
            'Nama Pemungut',
            'Kecamatan',
            'Total Harga',
            'Kategori',
            'Status',
            'Tanggal Pembayaran',
        ];
    }

    public function map($item): array
    {
        return [
            ++$this->numRows,
            $item->reference_number,
            $item->transaction_number,
            $item->user->name,
            $item->user->nik,
            $item->pemungut->name,
            $item->sub_district->name,
            $item->price,
            $item->category->name,
            $item->status ? 'Lunas' : 'Belum Lunas',
            $item->created_at,
        ];
    }
}
