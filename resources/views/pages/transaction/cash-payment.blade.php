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
        <div class="row align-items-center">
            <div class="col-md-6">
                <a class="button-primary text-center px-4" href="{{ url()->current() }}">Download Excel &nbsp;<i
                        class="bi bi-download"></i></a>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-6">
                        <label for="" class="form-label fs-7 fw-medium">Pilih Bulan</label>
                        <select class="form-select fs-7" aria-label="Default select example">
                            <option value="1" selected>Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">March</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="" class="form-label fs-7 fw-medium">Pilih Kecamatan</label>
                        <select class="form-select fs-7" aria-label="Default select example">
                            <option value="0" selected>Semua</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mt-4">
            <table class="table fs-7 table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < 10; $i++)
                        <tr>
                            <th scope="row">{{ $i + 1 }}</th>
                            <td><span class="">Kec. {{ fake()->city() }}</span></td>
                            <td>Rp. {{ number_format(fake()->randomNumber(5, true), 2) }}</td>
                            <td class="@if($i % 2 == 0) fw-medium @endif">{{ fake()->randomElement(['Belum Disetor', 'Sudah disetor']) }}</td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('javascript')
@endsection
