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
                @error('selected_masyarakat_id')
                    <div class="alert alert-danger alert-dismissible fade show fs-7" role="alert">
                        {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @enderror
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" value="" id="select_all">
                    <label class="form-check-label fs-7" for="select_all">
                        Pilih semua
                    </label>
                </div>
                <div class="d-flex flex-wrap gap-4">
                    @foreach ($pemungut->pemungut_category as $item)
                        <div class="form-check">
                            <input class="form-check-input check-masyarakat" type="checkbox" data-id="{{ $item->user->id }}"
                                id="flexCheckChecked">
                            <label class="form-check-label fs-7" for="flexCheckChecked">
                                <div class="d-flex flex-column">
                                    <span class="fw-medium">
                                        <a href="{{ route('masyarakat.show', $item->user->id) }}">
                                            {{ $item->user->name }}
                                        </a>
                                    </span>
                                    <span class="fs-8 fst-italic">Telp : {{ $item->user->phoneNumber }}</span>
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex gap-3 mt-4">
                    <button class="button-primary text-center" data-bs-toggle="modal" id="verification_button"
                        data-bs-target="#exampleModal">Verifikasi</button>
                    <a class="button-danger text-center" href="{{ route('masyarakat.verification') }}">Batal</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content fs-7">
                <div class="modal-header">
                    <h5 class="modal-title fw-medium" id="exampleModalLabel">Verifikasi Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin verifikasi akun tersebut?
                </div>
                <div class="modal-footer">
                    <form action="{{ route('masyarakat.verification.detail.store') }}" method="post">
                        @csrf
                        <input type="hidden" id="selected-masyarakat-id" name="selected_masyarakat_id">
                        <button type="submit" class="btn btn-primary fs-7 disabled" id="button_save">Simpan</button>
                    </form>
                    <button type="button" class="btn btn-secondary fs-7" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="{{ asset('assets/js/verification.js') }}"></script>
@endsection
