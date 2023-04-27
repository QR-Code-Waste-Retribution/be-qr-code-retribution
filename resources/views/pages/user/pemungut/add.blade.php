@extends('layout.app')

@section('css')
@endsection

@php
    $page_subtitle = false;
@endphp

@section('page_title', 'TAMBAH AKUN PETUGAS PEMUNGUT')
{{-- @section('page_subtitle', 'Anda dapat menambah, menghapus, dan menambahkan akun masyarakat baru') --}}
@section('breadcrumb_title', 'User')

@section('body')
    <div class="col-lg-12">
        <form class="row g-3" action="{{ route('pemungut.store') }}" method="POST">
            @csrf
            <div class="col-12">
                <label for="inputNanme4" class="form-label fs-7">Nama<span class="text-danger">*</span></label>
                <input type="text" class="form-control fs-7 @error('name') is-invalid @enderror" name="name"
                    id="inputNanme4" placeholder="Nama">
                @error('name')
                    <div class="invalid-feedback fs-8">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12">
                <label for="inputEmail4" class="form-label fs-7">Username<span class="text-danger">*</span></label>
                <input type="text" class="form-control fs-7  @error('name') is-invalid @enderror" id="inputEmail4"
                    name="username" placeholder="Username">
                @error('username')
                    <div class="invalid-feedback fs-8">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12">
                <label for="inputEmail4" class="form-label fs-7">Kecamatan<span class="text-danger">*</span></label>
                <select class="form-select fs-7 @error('kecamatan') is-invalid @enderror" name="kecamatan" aria-label="Default select example">
                    <option disabled selected>Pilih Kecamatan</option>
                    @foreach ($sub_districts as $item)
                        <option value="{{$item->id}}">{{ $item->name }}</option>
                    @endforeach
                </select>
                @error('kecamatan')
                    <div class="invalid-feedback fs-8">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12">
                <label for="inputAddress" class="form-label fs-7">Jenis Kelamin<span class="text-danger">*</span></label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="flexRadioDefault1" value="Laki-Laki" checked>
                    <label class="form-check-label fs-7" for="flexRadioDefault1">
                        Pria
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="flexRadioDefault1" value="Perempuan">
                    <label class="form-check-label fs-7" for="flexRadioDefault1">
                        Wanita
                    </label>
                </div>
                @error('jenis_kelamin')
                    <div class="invalid-feedback fs-8">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12">
                <label for="inputAddress" class="form-label fs-7">No. Telepon<span class="text-danger">*</span></label>
                <input type="text" class="form-control fs-7 @error('nomor_telepon') is-invalid @enderror" id="inputAddress" name="nomor_telepon" placeholder="No. Telepon">
                @error('nomor_telepon')
                    <div class="invalid-feedback fs-8">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12">
                <label for="inputAddress" class="form-label fs-7">Alamat</label>
                <input type="text" class="form-control fs-7  @error('alamat') is-invalid @enderror" id="inputAddress" name="alamat" placeholder="Alamat">
                @error('alamat')
                    <div class="invalid-feedback fs-8">{{ $message }}</div>
                @enderror
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success fs-7">Tambah</button>
                <a href="{{ route('pemungut.index') }}" class="btn btn-danger fs-7">Batal</a>
            </div>
        </form>
    </div>
@endsection
@section('javascript')
@endsection
