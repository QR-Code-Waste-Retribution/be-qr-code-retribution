@extends('layout.app')

@section('css')
@endsection
@php
    $button = false;
    $page_subtitle = true;
@endphp

@section('page_title', 'DATA AKUN MASYARAKAT')
@section('page_subtitle', 'Anda dapat menambah, menghapus, dan menambahkan akun masyarakat baru')
@section('breadcrumb_title', 'User')


@section('body')
    <div class="col-lg-12">
        <div class="row box-container">
            <div class="col-12">
                <form method="GET" action="{{ route('masyarakat.index') }}">
                    <div class="d-flex justify-content-between gap-5">
                        <div class="search-bar">
                            <div class="search-form d-flex align-items-center">
                                <input type="text" name="search" placeholder="Cari nama atau nomor telepon"
                                    title="Enter search keyword" value="{{ request()->input('search') }}">
                                <button type="button" title="Search"><i class="bi bi-search"></i></button>
                            </div>
                        </div>
                        <select class="form-select fs-7 w-25" name="sub_district" aria-label="Default select example">
                            <option disabled>Pilih Kecamatan</option>
                            <option value="all">Semua Kecamatan</option>
                            @foreach ($sub_districts as $item)
                                <option value="{{ $item->id }}" @if (request()->input('sub_district') == $item->id) selected @endif>Kec.
                                    {{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" title="Search" class="btn button-search btn-primary fs-7 px-3 py-2 my-2"><i
                                class="bi bi-search"></i>&nbsp; Search</button>
                    </div>
                </form>
            </div>
            <hr>
            <div class="col-12 mt-4">
                <table class="table fs-7 table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" class="w-50">Nama</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($masyarakat as $key => $item)
                            <tr>
                                <th scope="row">{{ (request()->input('page', 1) - 1) * 10 + $loop->iteration }}</th>
                                <td><span class="fw-semibold">{{ $item->name }}</span><br> {{ $item->phoneNumber }}
                                </td>
                                <td>Kec. {{ $item->sub_district->name }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn button btn-warning">Edit</button>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input switch-activated statusCheckChecked" type="checkbox"
                                                id="statusCheckChecked" checked data-user-id="{{ $item->id }}">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            {{ $masyarakat->links() }}
        </div>
    </div>
@endsection
@section('javascript')
    <script src="{{ asset('assets/js/user.js') }}"></script>
@endsection
