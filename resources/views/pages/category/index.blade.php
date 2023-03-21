@extends('layout.app')

@section('css')
@endsection
@php
    $button = true;
    $page_subtitle = true;
@endphp

@section('page_title', 'MANAGEMENT KATEGORI')
@section('page_subtitle', 'Anda dapat menambah, menghapus, dan menambahkan ketegori pemungut baru')
@section('breadcrumb_title', 'User')
@section('button_text', 'Tambah kategori baru')


@section('body')
    <div class="col-lg-12">
        <div class="row box-container">
            <div class="col-12">
                <form method="GET" action="{{ route('masyarakat.index') }}">
                    <div class="d-flex align-items-center gap-5">
                        <div class="search-bar">
                            <div class="search-form d-flex align-items-center">
                                <input type="text" name="search" placeholder="Cari kategori"
                                    title="Enter search keyword" value="{{ request()->input('search') }}">
                                <button type="button" title="Search"><i class="bi bi-search"></i></button>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" title="Search" class="btn button-search btn-primary fs-7 px-3 py-2 my-2"><i
                                    class="bi bi-search"></i>&nbsp; Search</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-12 mt-4">
                <table class="table fs-7 table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Harga Tarif</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $item)
                            <tr>
                                <th scope="row">{{ (request()->input('page', 1) - 1) * 10 + $loop->iteration }}</th>
                                <td>{{ $item->name }}</td>
                                <td>Rp. {{ number_format($item->price, 2) }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a class="btn button btn-warning"
                                            href="{{ route('category.edit', $item->id) }}">Edit</a>
                                        <a class="btn button btn-danger"
                                            href="{{ route('category.destroy', $item->id) }}">Delete</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $categories->links() }}
        </div>
    </div>
@endsection
@section('javascript')
@endsection
