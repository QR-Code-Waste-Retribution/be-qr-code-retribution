@extends('layout.app')

@section('css')
    <style>
        .detail-transaction td {
            padding-top: 10px;
            padding-bottom: 10px;
            padding-right: 10px;
        }
    </style>
@endsection

@php
    $page_subtitle = false;
@endphp

@section('page_title', 'DATA TRANSAKSI - Pembayaran Tunai - Detail')
@section('breadcrumb_title', 'Data Transaksi')

@section('body')
    <div class="col-lg-12 detail-transaction">
        <table>
            <tbody class="fs-7">
                <tr>
                    <td>Nama Petugas</td>
                    <td>:</td>
                    <td>{{ $cash->name }}</td>
                </tr>
                <tr>
                    <td>Kecamatan</td>
                    <td>:</td>
                    <td>{{ $cash->sub_district->name }}</td>
                </tr>
                <tr>
                    <td>Waktu</td>
                    <td>:</td>
                    <td>{{ $cash->transaction_date_in_arreas }} </td>
                </tr>
                <tr>
                    <td>Jumlah</td>
                    <td>:</td>
                    <td>Rp. {{ number_format($cash->total, 2) }} - </td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>:</td>
                    <td>
                        @if ($cash->transaction_status)
                            <span class="badge bg-success">Sudah Disetor</span>
                        @else
                            <span class="badge bg-danger">Belum Disetor</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="fs-7 mt-2">Apakah anda sudah menerima setoran sesuai dengan jumlah yang tertera?? Jika sudah, segera ubah
            status setoran
            dengan klik button <b>Sudah Setor</b> dibawah ini </p>
        @if (!$cash->transaction_status)
            <form action="{{ route('cash.payment.change.status') }}" method="post">
                @csrf
                @method('PUT')
                <input type="hidden" name="pemungut_transaction_id"
                    value="{{ implode(',', $cash->transaction_id->toArray()) }}">
                <button type="submit" class="btn button-search btn-primary fs-8 px-3 py-2 my-2">Sudah Setor</button>
                <a href="{{ route('transaction-cash.index') }}" class="btn btn-danger fs-8 px-3 py-2 my-2">Batal</a>
            </form>
        @else
            <a href="{{ route('transaction-cash.index') }}" class="btn btn-danger fs-8 px-3 py-2 my-2">Kembali</a>
        @endif
    </div>
@endsection
@section('javascript')
@endsection
