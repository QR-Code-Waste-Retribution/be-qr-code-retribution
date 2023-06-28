@extends('layout.app')

@section('css')
@endsection
@php
    $button = true;
    $page_subtitle = true;
@endphp

@section('page_title', 'CATATAN LAPORAN - Setoran ke Kas Daerah')
@section('page_subtitle',
    'Anda dapat melihat dan menambahkan catatan terkait penyetoran iuran retribusi ke Dinas
    Pendapatan')
@section('breadcrumb_title', 'Catatan Laporan')
@section('button_text', 'Tambah Catatan baru')


@section('body')
    <div class="col-lg-12">
        <div class="row box-container">
            <div class="col-12 d-flex justify-content-between">
                <div class="search-bar">
                    <form method="GET" action="{{ route('category.index') }}">
                        <div class="d-flex align-items-center gap-3">
                            <div class="search-bar">
                                <div class="search-form d-flex align-items-center">
                                    <input type="text" name="search" placeholder="Cari nama setoran" title="Enter search keyword"
                                        value="{{ request()->input('search') }}">
                                    <button type="button" title="Search"><i class="bi bi-search"></i></button>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" title="Search"
                                    class="btn button-search btn-primary fs-7 px-3 py-2 my-2"><i class="bi bi-search"></i>&nbsp;
                                    Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-12 mt-4">
                <table class="table fs-7 table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Setoran</th>
                            <th scope="col">Pemungut</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Catatan</th>
                            <th scope="col">Bukti Bayar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($report as $item)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->user->name }} <br> <span class="fs-8 fst-italic">{{ $item->user->phoneNumber }}</span></td>
                                <td>Rp. {{ number_format($item->price, 2) }}</td>
                                <td>{{ $item->reports_date }}</td>
                                <td>{{ $item->notes }}</td>
                                <td><img src="{{ asset($item->payment_file_url) }}"
                                        style="width: 100px">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="{{ asset('assets/js/category.js') }}"></script>
@endsection
