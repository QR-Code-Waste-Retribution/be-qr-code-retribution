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
                    <td>Jenis Kelamin</td>
                    <td>:</td>
                    <td>{{ $cash->gender }}</td>
                </tr>
                <tr>
                    <td>Nomor Telepon</td>
                    <td>:</td>
                    <td>{{ $cash->phoneNumber }}</td>
                </tr>
                <tr>
                    <td>Kecamatan</td>
                    <td>:</td>
                    <td>{{ $cash->sub_district->name }}</td>
                </tr>
                @if ($cash->pemungut_transactions->pluck('status')->contains(0))
                    <tr>
                        <td>Waktu</td>
                        <td>:</td>
                        <td>{{ $cash->transaction_date_in_arreas }} </td>
                    </tr>
                    <tr>
                        <td>Jumlah</td>
                        <td>:</td>
                        <td>Rp.
                            {{ number_format(
                                $cash->pemungut_transactions->sum(function ($user) {
                                    if (!$user->status) {
                                        return $user->masyarakat_transactions->sum('price');
                                    }
                                }),
                                2,
                            ) }}
                            - </td>
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
                @endif
            </tbody>
        </table>
        @if ($cash->pemungut_transactions->pluck('status')->contains(0))
            <p class="fs-7 mt-2">Apakah anda sudah menerima setoran sesuai dengan jumlah yang tertera?? Jika sudah, segera
                ubah
                status setoran
                dengan klik button <b>Sudah Setor</b> dibawah ini </p>
            <form action="{{ route('cash.payment.change.status') }}" method="post">
                @csrf
                @method('PUT')
                <input type="hidden" name="pemungut_transaction_id"
                    value="{{ $cash->pemungut_transactions->pluck('id')->implode(',') }}">
                <button type="submit" class="btn button-search btn-primary fs-8 px-3 py-2 my-2">Sudah Setor</button>
                <a href="{{ route('transaction-cash.index') }}" class="btn btn-danger fs-8 px-3 py-2 my-2">Batal</a>
            </form>
            <div class="col-lg-12 detail-transaction">
                <table class="table fs-7 mt-2">
                    <thead>
                        <tr class="table-dark">
                            <th scope="col">#</th>
                            <th scope="col" style="py-3">Nama Wajib Retribusi</th>
                            <th scope="col" style="py-3">Total Pembayaran</th>
                            <th scope="col" style="py-3">Tanggal Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @isset($cash->pemungut_transactions)
                            @foreach ($cash->pemungut_transactions as $pt)
                                @if (!$pt->status)
                                    @php
                                        $iteration_parent = 0;
                                    @endphp
                                    @foreach ($pt->masyarakat_transactions as $item)
                                        @php
                                            if ($loop->last) {
                                                $iteration = $loop->iteration;
                                            }
                                        @endphp
                                        <tr class="bg-warning">
                                            <th scope="row" class="border-1 border-top">
                                                {{ $loop->iteration + $iteration_parent }}</th>
                                            <td>
                                                @if ($item->user->name === $cash->name)
                                                    <span class="badge text-bg-success">Kategori Wajib Retribusi Tambahan</span>
                                                @else
                                                    {{ $item->user->name }}
                                                @endif
                                            </td>
                                            <td>Rp. {{ number_format($item->price, 2) }} -</td>
                                            <td><span
                                                    class="">{{ date('d M Y H:i:s', strtotime($item->created_at)) }}</span>
                                            </td>
                                        </tr>
                                        @if (count($item->invoice))
                                            <tr>
                                                <td class="border-0"></td>
                                                <td scope="col" class="fw-medium border-0" colspan="4">Kategori Wajib
                                                    Retribusi
                                                </td>
                                            </tr>
                                            @foreach ($item->invoice as $item)
                                                <tr>
                                                    <td class="border-0"></td>
                                                    <td>{{ $item->category->name }}</td>
                                                    <td>Rp. {{ number_format($item->price, 2) }} -</td>
                                                    <td>{{ $item->category->type }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        @endisset
                    </tbody>
                </table>
            </div>
        @else
            <div class="container p-0 mt-5">
                <div class="row p-0">
                    <div class="col-md-12 p-0">
                        <p class="fw-bold fs-4">Riwayat Pembayaran</p>
                        <table class="table fs-7 mt-2">
                            <thead>
                                <tr class="table-dark">
                                    <th scope="col">#</th>
                                    <th scope="col" style="py-3">Total Penyetoran</th>
                                    <th scope="col" style="py-3">Tanggal Penyetoran</th>
                                    <th scope="col" style="py-3">Jumlah Pemungutan Retribusi</th>
                                    <th scope="col" style="py-3">Jumlah Kategori Retribusi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($cash->pemungut_transactions)
                                    @foreach ($cash->pemungut_transactions as $item)
                                        <tr>
                                            <th scope="row" class="border-1 border-top">{{ $loop->iteration }}</th>
                                            <td><span
                                                    class="">{{ number_format($item->masyarakat_transactions->sum('price'), 2) }}
                                                </span>
                                            </td>
                                            <td><span
                                                    class="">{{ date('d M Y H:i:s', strtotime($item->updated_at)) }}</span>
                                            <td>{{ count($item->masyarakat_transactions) }} Pemungutan</td>
                                            </td>
                                            <td>{{ $item->masyarakat_transactions->count('invoice') }} Tagihan
                                            </td>
                                        </tr>
                                    @endforeach
                                @endisset
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <a href="{{ route('transaction-cash.index') }}" class="btn btn-danger fs-8 px-3 py-2 my-2">Kembali</a>
        @endif
    </div>
@endsection
@section('javascript')
@endsection
