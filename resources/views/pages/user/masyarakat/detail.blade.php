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
                        
                        <x-sub-district-dropdown col="3" />
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($masyarakat as $key => $item)
                            <tr>
                                <th scope="row">{{ (request()->input('page', 1) - 1) * 10 + $loop->iteration }}</th>
                                <td>
                                    <a href="{{ route('') }}">
                                        <span class="fw-semibold">{{ $item->name }}</span>
                                        <br> 
                                        {{ $item->phoneNumber }}
                                    </a>
                                </td>
                                <td>Kec. {{ $item->sub_district->name }}</td>
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
