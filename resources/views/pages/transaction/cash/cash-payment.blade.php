@extends('layout.app')

@section('css')
@endsection

@php
    $page_subtitle = true;
@endphp

@section('page_title', 'DATA TRANSAKSI - Pembayaran Tunai')
@section('page_subtitle', 'Anda dapat melihat iuran retribusi sampah yang sudah di kumpulkan oleh petugas pemungut')
@section('breadcrumb_title', 'Data Transaksi')

@section('body')
    <div class="col-lg-12">
        <div class="row align-items-center box-container">
            <div class="col-4">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">Target Pemasukan <span>| Bulan Ini</span></h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                            <div class="ps-3">
                                @if (!isset($invoice_monthly['unpaid']) && isset($invoice_monthly['paid']))
                                    <h6 class="fs-4">Rp.
                                        {{ number_format($invoice_monthly['paid']['total'] ?? 0, 2) }}
                                        -,</h6>
                                @elseif(!isset($invoice_monthly['paid']) && isset($invoice_monthly['unpaid']))
                                    <h6 class="fs-4">Rp.
                                        {{ number_format($invoice_monthly['unpaid']['total'] ?? 0, 2) }}
                                        -,</h6>
                                @elseif(!isset($invoice_monthly['paid']) && !isset($invoice_monthly['unpaid']))
                                    <h6 class="fs-4">Rp.
                                        {{ 0 }}
                                        -,</h6>
                                @else
                                    <h6 class="fs-4">Rp. 
                                        {{ number_format($invoice_monthly['unpaid']['total'] ?? 0 + $invoice_monthly['paid']['total'] ?? 0, 2) }}
                                        -,</h6>
                                @endif
                                <span class="text-success small pt-1 fw-bold"></span><span
                                    class="text-muted small pt-2 ps-1">21 Februari 2023</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-12">
                <a class="button-primary text-center px-4" href="{{ route('transaction-cash.export') }}">Download Excel
                    &nbsp;<i class="bi bi-download"></i></a>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-12">
                        <form method="GET" action="{{ route('transaction-cash.status.index', ['status' => $status]) }}">
                            <div class="d-flex justify-content-between gap-5 align-items-center">
                                <div class="search-bar">
                                    <div class="search-form d-flex align-items-center mt-4">
                                        <input type="text" name="search" placeholder="Cari nama atau nomor telepon"
                                            title="Enter search keyword" value="{{ request()->input('search') }}">
                                        <button type="button" title="Search"><i class="bi bi-search"></i></button>
                                    </div>
                                </div>
                                <x-month-select col="3" />
                                <x-sub-district-dropdown col="3" />
                            </div>
                            <div class="w-100 d-flex justify-content-end">
                                <button type="submit" title="Search"
                                    class="btn button-search btn-primary fs-7 px-3 py-2 my-2"><i
                                        class="bi bi-search"></i>&nbsp; Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-12 mt-4">
            <table class="table fs-7 table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Petugas</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Waktu</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pemungut_transactions as $item)
                        <tr>
                            <th scope="row">{{ (request()->input('page', 1) - 1) * 10 + $loop->iteration }}</th>
                            <td><a class="" href="{{ route('transaction-cash.show', $item->id) }}"><span
                                        class="fw-semibold">{{ $item->name }}</span><br>
                                    Kec. {{ $item->sub_district->name }}</a></td>
                            <td>Rp.
                                {{ number_format(
                                    $item->pemungut_transactions->sum(function ($user) {
                                        return $user->masyarakat_transactions->sum('price');
                                    }),
                                    2,
                                ) }}
                            </td>
                            <td>{{ \App\Models\PemungutTransaction::getRangeArreas($item->pemungut_transactions) }}</td>
                            <td class="">
                                @if (!(count($item->pemungut_transactions) <= 0))
                                    @if (!$item->pemungut_transactions[0]->status ?? 0)
                                        <span class="badge text-bg-danger">Belum Disetor</span>
                                    @else
                                        <span class="badge text-bg-success">Sudah Disetor</span>
                                    @endif
                                @else
                                    <span class="badge text-bg-warning">Belum ada pemungutan</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td>
                                <p class="text-danger fs-7">-</p>
                            </td>
                            <td>
                                <p class="text-danger fs-7">-</p>
                            </td>
                            <td>
                                <p class="text-danger fs-7">-</p>
                            </td>
                            <td>
                                <p class="text-danger fs-7">-</p>
                            </td>
                            <td>
                                <p class="text-danger fs-7">-</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $pemungut_transactions->onEachSide(5)->links() }}
        </div>
    </div>
@endsection
@section('javascript')
@endsection
