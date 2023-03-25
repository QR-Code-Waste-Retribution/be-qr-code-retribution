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
            <div class="col-md-12">
                <div class="row">
                    <div class="col-12">
                        <form method="GET" action="{{ route('transaction-cash.index') }}">
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
                            <td><span class=""><span class="fw-semibold">{{ $item->name }}</span><br>
                                    Kec. {{ $item->sub_district->name }}</span></td>
                            <td>Rp. {{ number_format($item->pemungut_transactions[0]->total) }}</td>
                            <td>{{ date('F Y', strtotime($item->created_at)) }}</td>
                            <td class="">
                                @if (!$item->pemungut_transactions[0]->status)
                                    <span class="badge text-bg-danger">Belum Disetor</span>
                                @else
                                    <span class="badge text-bg-success">Sudah Disetor</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5"><p class="text-danger fs-6">No Item</p></td>
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
