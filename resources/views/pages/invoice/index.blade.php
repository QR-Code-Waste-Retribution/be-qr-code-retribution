@extends('layout.app')

@section('css')
@endsection
@php
    $page_subtitle = true;
@endphp

@section('page_title', 'TAGIHAN WAJIB RETRIBUSI')
@section('page_subtitle', 'Periksa kesesuaian data dengan tagihan yang akan di dibayarkan oleh masyarakat.')
@section('breadcrumb_title', 'User')

@section('body')
    <div class="col-lg-12">
        <div class="row box-container">
            <div class="col-12">
                <form method="GET" action="{{ route('invoice.index') }}">
                    <div class="d-flex align-items-center gap-4">
                        <div class="search-bar">
                            <div class="search-form d-flex align-items-center">
                                <input type="text" name="search" placeholder="Cari Tagihan" title="Enter search keyword"
                                    value="{{ request()->input('search') }}">
                                <button type="button" title="Search"><i class="bi bi-search"></i></button>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" title="Search"
                                class="btn button-search btn-primary fs-7 px-3 py-2 my-2"><i class="bi bi-search"></i>&nbsp;
                                Search</button>
                        </div>
                        <a class="btn btn-primary fs-7 px-4 py-2 my-2"
                            href="{{ route('invoice.index') }}">Tampilkan semua</a>
                    </div>
                </form>
            </div>
            <div class="col-12 mt-4">
                <table class="table fs-7">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Wajib Retribusi</th>
                            <th scope="col">NIK</th>
                            <th scope="col">Nomor Telepon</th>
                            <th scope="col">Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($invoices as $item)
                            <tr>
                                <td scope="row">{{ (request()->input('page', 1) - 1) * 10 + $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->nik }}</td>
                                <td>{{ $item->phoneNumber }}</td>
                                <td>{{ $item->address }}</td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <div class="container">
                                        <div class="row gap-3">
                                            @foreach ($item->invoices as $invoice)
                                                <div class="col-3 h-100 p-3 rounded-3 shadow">
                                                    <p class="m-0 mb-1 fw-bold">{{ $invoice->category->name }}
                                                    </p>

                                                    <p class="m-0 mb-1 fs-8 fst-italic">
                                                        {{ $invoice->users_categories->address }}
                                                    </p>

                                                    <p class="m-0 my-1">Rp.
                                                        {{ number_format($invoice->category->price, 2) }} / <span
                                                            class="badge bg-primary">
                                                            {{ $invoice->category->typeTranslation }}</span>
                                                    </p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-danger text-center">Data Tagihan tidak ada</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $invoices->links() }}
            </div>
        </div>
    </div>
@endsection
@section('javascript')

@endsection
