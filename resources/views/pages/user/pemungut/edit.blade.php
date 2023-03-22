@extends('layout.app')

@section('css')
@endsection

@php
    $page_subtitle = false;
@endphp

@section('page_title', 'EDIT AKUN PETUGAS PEMUNGUT')
{{-- @section('page_subtitle', 'Anda dapat menambah, menghapus, dan menambahkan akun masyarakat baru') --}}
@section('breadcrumb_title', 'User')

@section('body')
    <div class="col-lg-12">
        <form class="row g-3" action="{{ route('pemungut.update', $pemungut->id) }}" method="POST">
            @method("PATCH")
            @csrf
            <div class="col-12">
                <label for="inputNanme4" class="form-label fs-7">Nama<span class="text-danger">*</span></label>
                <input type="text" class="form-control fs-7 @error('name') is-invalid @enderror" name="name"
                    id="inputNanme4" placeholder="Nama" value="{{ $pemungut->name }}">
                @error('name')
                    <div class="invalid-feedback fs-8">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12">
                <label for="inputEmail4" class="form-label fs-7">Username<span class="text-danger">*</span></label>
                <input type="text" class="form-control fs-7  @error('name') is-invalid @enderror" id="inputEmail4"
                    name="username" placeholder="Username"  value="{{ $pemungut->username }}">
                @error('username')
                    <div class="invalid-feedback fs-8">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12">
                <label for="inputEmail4" class="form-label fs-7">Kecamatan<span class="text-danger">*</span></label>
                <select class="form-select fs-7 @error('kecamatan') is-invalid @enderror" name="kecamatan" aria-label="Default select example">
                    <option disabled>Pilih Kecamatan</option>
                    @foreach ($sub_districts as $item)
                        <option value="{{$item->id}}" @if ($pemungut->sub_district_id == $item->id)
                            selected
                        @endif>{{ $item->name }}</option>
                    @endforeach
                </select>
                @error('kecamatan')
                    <div class="invalid-feedback fs-8">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12">
                <label for="inputAddress" class="form-label fs-7">Jenis Kelamin<span class="text-danger">*</span></label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="flexRadioDefault1" value="Laki-Laki" @if ($pemungut->gender == 'Laki-Laki')
                        checked
                    @endif>
                    <label class="form-check-label fs-7" for="flexRadioDefault1">
                        Laki-Laki
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="flexRadioDefault1" value="Perempuan" @if ($pemungut->gender == 'Perempuan')
                        checked
                    @endif>
                    <label class="form-check-label fs-7" for="flexRadioDefault1">
                        Perempuan
                    </label>
                </div>
                @error('jenis_kelamin')
                    <div class="invalid-feedback fs-8">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12">
                <label for="inputAddress" class="form-label fs-7">No. Telepon<span class="text-danger">*</span></label>
                <input type="text" class="form-control fs-7 @error('nomor_telepon') is-invalid @enderror" id="inputAddress" name="nomor_telepon" placeholder="No. Telepon"  value="{{ $pemungut->phoneNumber }}">
                @error('nomor_telepon')
                    <div class="invalid-feedback fs-8">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12">
                <label for="inputAddress" class="form-label fs-7">Alamat</label>
                <input type="text" class="form-control fs-7  @error('alamat') is-invalid @enderror" id="inputAddress" name="alamat" placeholder="Alamat" value="{{ $pemungut->address }}">
                @error('alamat')
                    <div class="invalid-feedback fs-8">{{ $message }}</div>
                @enderror
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success fs-7">Edit Pemungut</button>
                <a href="{{ route('pemungut.index') }}" class="btn btn-danger fs-7">Batal</a>
            </div>
        </form>
    </div>
@endsection
@section('javascript')
@endsection
