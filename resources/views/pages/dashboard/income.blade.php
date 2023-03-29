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
            <div class="">
                <select class="form-select fs-7" aria-label="Default select example">
                    @php
                        $months = [
                            1 => 'Januari',
                            2 => 'Februari',
                            3 => 'Maret',
                            4 => 'April',
                            5 => 'Mei',
                            6 => 'Juni',
                            7 => 'Juli',
                            8 => 'Agustus',
                            9 => 'September',
                            10 => 'Oktober',
                            11 => 'November',
                            12 => 'Desember',
                        ];
                    @endphp
                    @foreach ($months as $key => $value)
                        <option value="{{ $key }}" @if ($key == 1) selected @endif>
                            {{ $value }}</option>
                    @endforeach
                </select>
            </div>
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
                    @for ($i = 0; $i < 10; $i++)
                        <tr>
                            <th scope="row">{{ $i + 1 }}</th>
                            <td>Kec. Balige</td>
                            <td>Rp. 1.243.000 -,</td>
                            <td>Rp. 243.000 -,</td>
                            <td>Rp. 1.243.000 -,</td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script>
        console.log('Testing')
    </script>
@endsection
