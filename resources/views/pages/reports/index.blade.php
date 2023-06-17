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
                    <form class="search-form d-flex align-items-center" method="POST" action="#">
                        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
                    </form>
                </div>
            </div>
            <div class="col-12 mt-4">
                <table class="table fs-7 table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Setoran</th>
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
                                <td>Rp {{ number_format($item->price, 2) }}</td>
                                <td>{{ $item->reports_date }}</td>
                                <td>{{ $item->notes }}</td>
                                <td><img src="https://imgv2-1-f.scribdassets.com/img/document/262678770/original/f989a7f8fe/1684204078?v=1"
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
