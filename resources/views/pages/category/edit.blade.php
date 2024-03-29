@extends('layout.app')

@section('css')
@endsection

@php
    $page_subtitle = false;
@endphp

@section('page_title', 'EDIT KATEGORI')
{{-- @section('page_subtitle', 'Anda dapat menambah, menghapus, dan menambahkan akun masyarakat baru') --}}
@section('breadcrumb_title', 'Management Category')

@section('body')
    <div class="col-lg-12">
        <form class="row g-3" action="{{ route('category.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="col-12">
                <label for="inputNanme4" class="form-label fs-7">Nama Kategori</label>
                <input type="text" class="form-control fs-7 @error('nama_kategori') is-invalid @enderror"
                    name="nama_kategori" id="inputNanme4" placeholder="Nama Kategori" value="{{ $category->name }}">
                @error('nama_kategori')
                    <div class="invalid-feedback fs-7">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12">
                <label for="inputEmail4" class="form-label fs-7">Harga Tarif</label>
                <input type="number" class="form-control fs-7 @error('harga_tarif') is-invalid @enderror"
                    name="harga_tarif" id="inputEmail4" placeholder="Harga Tarif" value="{{ $category->price }}">
                @error('harga_tarif')
                    <div class="invalid-feedback fs-7">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12">
                <label for="inputEmail4" class="form-label fs-7">Tipe Pembayaran Kategori</label>
                <select class="form-select fs-7 @error('tipe_pembayaran_kategori') is-invalid @enderror"
                    name="tipe_pembayaran_kategori" aria-label="Default select example">
                    <option disabled selected>Tipe Pembayaran Kategori</option>
                    <option value="MONTH" @if ($category->type == 'MONTH') selected @endif>Bulan</option>
                    <option value="DAY" @if ($category->type == 'DAY') selected @endif>Hari</option>
                    <option value="UNIT" @if ($category->type == 'UNIT') selected @endif>Unit</option>
                    <option value="PACKET" @if ($category->type == 'PACKET') selected @endif>Paket</option>
                </select>
                @error('tipe_pembayaran_kategori')
                    <div class="invalid-feedback fs-7">{{ $message }}</div>
                @enderror
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success fs-7">Edit</button>
                <a href="{{ route('category.index') }}" class="btn btn-danger fs-7">Batal</a>
            </div>
        </form>
    </div>
@endsection
@section('javascript')
@endsection
