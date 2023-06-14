@extends('layout.app')

@section('css')
@endsection
@php
    $button = false;
    $page_subtitle = true;
@endphp

@section('page_title', 'VERIFIKASI AKUN MASYARAKAT')
@section('page_subtitle')
    Anda dapat melihat data akun masyarakat yang baru 
    terdaftar di sistem retribusi sampah Kabupaten Toba
    <br>
    Lakukan verifikasi akun masyarakat
@endsection
@section('breadcrumb_title', 'User')


@section('body')
    <div class="col-lg-12">
        <div class="row box-container">
            <div class="col-12 mt-4">
                <p>AKUN MASYARAKAT - <span class="fw-bold">{{ $pemungut->name }}</span> - <span class="fw-medium">Kec.
                        {{ $pemungut->sub_district->name }}</span></p>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" value="" id="select_all">
                    <label class="form-check-label fs-7" for="select_all">
                        Select All
                    </label>
                </div>
                <div class="d-flex flex-wrap gap-4">
                    @foreach ($pemungut->pemungut_category as $item)
                        <div class="form-check">
                            <input class="form-check-input check-masyarakat" type="checkbox" value="" id="flexCheckChecked">
                            <label class="form-check-label fs-7" for="flexCheckChecked">
                                <span class="fw-medium">{{ $item->user->name }}</span><br>
                                <span class="fs-8 fst-italic">Telp : {{ $item->user->phoneNumber }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex gap-3 mt-4">
                    <button class="button-primary text-center">Verifikasi</button>
                    <a class="button-danger text-center" href="{{ route('masyarakat.verification') }}">Batal</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="{{ asset('assets/js/verification.js') }}"></script>
@endsection
