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
        <form class="row g-3" action="{{ route('user.pemungut.store') }}" method="POST">
            @csrf
            <div class="col-12">
                <label for="inputNanme4" class="form-label fs-7">Nama</label>
                <input type="text" class="form-control fs-7" name="name"  id="inputNanme4" placeholder="Nama">
            </div>
            <div class="col-12">
                <label for="inputEmail4" class="form-label fs-7">Username/Email</label>
                <input type="email" class="form-control fs-7" id="inputEmail4" placeholder="Username/Email">
            </div>
            <div class="col-12">
                <label for="inputPassword4" class="form-label fs-7">Password</label>
                <input type="password" class="form-control fs-7" id="inputPassword4" placeholder="Password">
            </div>
            <div class="col-12">
                <label for="inputAddress" class="form-label fs-7">Jenis Kelamin *</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
                    <label class="form-check-label fs-7" for="flexRadioDefault1">
                        Pria
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                    <label class="form-check-label fs-7" for="flexRadioDefault1">
                        Wanita
                    </label>
                </div>
            </div>
            <div class="col-12">
                <label for="inputAddress" class="form-label fs-7">No. Telepon</label>
                <input type="text" class="form-control fs-7" id="inputAddress" placeholder="No. Telepon">
            </div>
            <div class="col-12">
                <label for="inputAddress" class="form-label fs-7">Alamat</label>
                <input type="text" class="form-control fs-7" id="inputAddress" placeholder="Alamat">
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
