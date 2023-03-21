@extends('layout.app')

@section('css')
@endsection

@php
    $page_subtitle = false;
@endphp

@section('page_title', 'TAMBAH KATEGORI BARU')
{{-- @section('page_subtitle', 'Anda dapat menambah, menghapus, dan menambahkan akun masyarakat baru') --}}
@section('breadcrumb_title', 'Management Category')

@section('body')
    <div class="col-lg-12">
        <form class="row g-3" action="{{ route('category.store') }}" method="POST">
            @csrf
            <div class="col-12">
                <label for="inputNanme4" class="form-label fs-7">Nama Kategori</label>
                <input type="text" class="form-control fs-7 @error('nama_kategori') is-invalid @enderror" name="nama_kategori"
                    id="inputNanme4" placeholder="Nama Kategori">
                @error('nama_kategori')
                    <div class="invalid-feedback fs-7">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12">
                <label for="inputEmail4" class="form-label fs-7">Harga Tarif</label>
                <input type="number" class="form-control fs-7 @error('harga_tarif') is-invalid @enderror" name="harga_tarif"
                id="inputEmail4" placeholder="Harga Tarif">
                @error('harga_tarif')
                    <div class="invalid-feedback fs-7">{{ $message }}</div>
                @enderror
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success fs-7">Tambah</button>
                <button type="reset" class="btn btn-danger fs-7">Batal</button>
            </div>
        </form>
    </div>
@endsection
@section('javascript')
@endsection
