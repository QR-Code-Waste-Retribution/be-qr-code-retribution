@extends('layout.app')

@section('css')

@endsection

@php
    $button = true;
    $page_subtitle = true;
@endphp

@section('page_title', 'VERIFIKASI AKUN MASYARAKAT')

@section('page_subtitle')
    Anda dapat melihat data akun masyarakat yang baru terdaftar di sistem retribusi sampah Kabupaten Toba
    <br>Lakukan verifikasi akun masyarakat
@endsection

@section('breadcrumb_title', 'User')

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
                <div class="">
                    <select class="form-select  fs-7" aria-label="Default select example">
                        <option selected disabled>Pilih kategori user</option>
                        <option value="all">Semua</option>
                        <option value="1">Kec. Ajibata</option>
                        <option value="1">Kec. Balige</option>
                        <option value="1">Kec. Bonatua Lunasi</option>
                    </select>
                </div>
            </div>
            <div class="col-12 mt-4">
                <table class="table fs-7 table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Kecamatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pemunguts as $item)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>
                                    <a href="{{ route('masyarakat.verification.detail', $item->id) }}">
                                        {{ $item->name }} <br> <span class="fst-italic" style="font-size: 12px">{{ $item->phoneNumber }}</span>
                                    </a>
                                </td>
                                <td>Kec. {{ $item->sub_district->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('javascript')

@endsection
