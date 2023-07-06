@extends('layout.app')

@section('css')
@endsection
@php
    $button = true;
    $page_subtitle = true;
@endphp

@section('page_title', 'DATA AKUN PETUGAS PEMUNGUT')
@section('page_subtitle', 'Anda dapat menambah, menghapus, dan menambahkan akun masyarakat baru')
@section('breadcrumb_title', 'User')


@section('body')
    <div class="col-lg-12">
        <div class="row box-container">
            <div class="col-12">
                <form method="GET" action="{{ route('pemungut.index') }}">
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
            <div class="col-12 mt-4">
                <table class="table fs-7 table-hover">
                    <thead>
                        <tr>
                            {{-- <th scope="col"></th> --}}
                            <th scope="col">#</th>
                            <th scope="col" class="w-75">Name</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pemungut as $item)
                            <tr>
                                {{-- <td><input type="checkbox" class="form-check-input" name="" id=""></td> --}}
                                <td scope="row">{{ (request()->input('page', 1) - 1) * 10 + $loop->iteration }}</td>
                                <td><span class="fw-semibold">{{ $item->name }}</span><br>Kec. {{ $item->sub_district->name }}
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <div>
                                            <a class="btn button btn-warning fs-7"
                                                href="{{ route('pemungut.edit', $item->id) }}">Edit</a>
                                        </div>
                                        <div class="d-flex flex-column align-items-center justify-content-center" style="width: 60px;">
                                            <div class="text-center">
                                                <div class="form-check form-switch">
                                                    <input
                                                        class="form-check-input d-flex flex-column switch-activated statusCheckChecked"
                                                        type="checkbox" id="statusCheckChecked"
                                                        @if ($item->account_status) checked @endif
                                                        data-user-id="{{ $item->id }}">
                                                </div>
                                                <p class="fs-9 m-0" id="text-status-{{ $item->id }}">
                                                    @if ($item->account_status)
                                                        Active
                                                    @else
                                                        Inactive
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="spinner-border d-none" id="spinnder-border-{{ $item->id }}"
                                                style="width: 1.5rem; height: 1.5rem;" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $pemungut->links() }}
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="{{ asset('assets/js/pemungut.js') }}"></script>
@endsection
