@extends('layout.app')

@section('css')
@endsection

@php
    $page_subtitle = true;
@endphp

@section('page_title', 'Dashboard - Pemasukan per Kecamatan')
@section('page_subtitle',
    'Anda dapat melihat iuaran retrobusi sampah yang sudah terkumpul dari tiap Kecamatan yang ada
    di kabupaten Toba')
@section('breadcrumb_title', 'Pemasukan')

@section('body')
    <div class="col-lg-12 box-container">
        <div class="col-12 d-flex justify-content-between">
            <div class="search-bar">
                <form class="search-form d-flex align-items-center" method="POST" action="#">
                    <input type="text" name="query" placeholder="Cari Kecamatan" title="Enter search keyword">
                    <button type="submit" title="Search"><i class="bi bi-search"></i></button>
                </form>
            </div>
            <x-month-select col="3" />
        </div>
        <div class="col-12 mt-4">
            <table class="table fs-7 table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Kecamatan</th>
                        <th scope="col">Total Iuran Terkumpul</th>
                        <th scope="col">Tunai</th>
                        <th scope="col">Non Tunai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>Kec. {{ $item['sub_district']['name'] }}</td>
                            <td>Rp. {{ number_format($item['total'], 2) }} -,</td>
                            <td>Rp. {{ number_format($item['cash'], 2) }} -,</td>
                            <td>Rp. {{ number_format($item['noncash'], 2) }} -,</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $transactions->links() }}
        </div>
    </div>
@endsection
@section('javascript')
    <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script>
        console.log('Testing')
    </script>
@endsection
