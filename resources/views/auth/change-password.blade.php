@extends('layout.app')

@section('css')
@endsection
@php
    $page_subtitle = true;
@endphp

@section('page_title', 'Ganti Password')
@section('page_subtitle', '')
@section('breadcrumb_title', 'profile')

@section('body')
    <div class="col-lg-12">
        <form class="row g-3" action="{{ route('user.change.password.put') }}" method="POST">
            @csrf
            <div class="col-12">
                <label for="inputNanme4" class="form-label fs-7">Password Lama</label>
                <input type="password" class="form-control fs-7 @error('password_lama') is-invalid @enderror"
                    name="password_lama" id="inputNanme4" placeholder="Password Lama" value="{{ @old('password_lama') }}">
                @error('password_lama')
                    <div class="invalid-feedback fs-7">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12">
                <label for="inputEmail4" class="form-label fs-7">Password Baru</label>
                <input type="password" class="form-control fs-7 @error('password') is-invalid @enderror"
                    name="password" id="inputEmail4" placeholder="Password Baru" value="{{ @old('password') }}">
                @error('password')
                    <div class="invalid-feedback fs-7">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12">
                <label for="inputEmail4" class="form-label fs-7">Konfirmasi Password Baru</label>
                <input type="password" class="form-control fs-7 @error('password_confirmation') is-invalid @enderror"
                    name="password_confirmation" id="inputEmail4" placeholder="password_confirmation Baru" value="{{ @old('password_confirmation') }}">
                @error('password_confirmation')
                    <div class="invalid-feedback fs-7">{{ $message }}</div>
                @enderror
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success fs-7">Simpan</button>
                <a href="{{ route('user.profile') }}" class="btn btn-danger fs-7">Batal</a>
            </div>
        </form>
    </div>
@endsection
@section('javascript')
@endsection
