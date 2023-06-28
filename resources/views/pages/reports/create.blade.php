@extends('layout.app')

@section('css')
@endsection

@php
    $page_subtitle = false;
@endphp

@section('page_title', 'CATATAN LAPORAN - Tambah Catatan Laporan Baru')
@section('breadcrumb_title', 'Catatan Laporan')

@section('body')
    <div class="col-lg-12">
        <form class="row g-3" action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-12">
                <label for="inputNanme4" class="form-label fs-7">Nama Setoran</label>
                <input type="text" class="form-control fs-7 @error('reports_name') is-invalid @enderror"
                    name="reports_name" id="inputNanme4" placeholder="Setoran" value="{{ old('reports_name') }}">
                @error('reports_name')
                    <div class="invalid-feedback fs-8">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12">
                <label for="inputEmail4" class="form-label fs-7">Nama Pemungut <span class="text-primary fs-8">(Pembayaran
                        Tunai)</span></label>
                <select class="form-select fs-7" name="pemungut_id" aria-label="Default select example"
                    id="select_pemungut">
                    <option selected value="0" data-price="0">Pilih pemungut</option>
                    @forelse ($pemungut as $item)
                        <option value="{{ $item->id }}" @if (old('pemungut_id') == $item->id) selected @endif
                            data-price={{ $item->pemungut_transactions->sum('masyarakat_transactions_sum_price') }}>
                            {{ $item->name }}</option>
                    @empty
                        <option disabled>Belum ada pemungut yang terdaftar</option>
                    @endforelse
                </select>
                @error('pemungut_id')
                    <div class="invalid-feedback fs-8">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12">
                <label for="price" class="form-label fs-7">Jumlah Setoran</label>
                <div class="input-group flex-nowrap">
                    <span class="input-group-text fs-7" id="addon-wrapping">Rp</span>
                    <input type="number" class="form-control fs-7 @error('price') is-invalid @enderror"
                        placeholder="Jumlah setoran" id="price" name="price" value="{{ old('price') }}">
                </div>
                @error('price')
                    <div class="text-danger fs-8 mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12">
                <label for="inputEmail4" class="form-label fs-7">Nomor STS <span class="text-primary fs-8">(Pembayaran
                        Tunai)</span></label>
                <input type="text" class="form-control fs-7 @error('sts_no') is-invalid @enderror" name="sts_no"
                    id="inputEmail4" value="{{ old('sts_no') }}">
                @error('sts_no')
                    <div class="invalid-feedback fs-8">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12">
                <label for="inputEmail4" class="form-label fs-7">Tanggal</label>
                <input type="date" class="form-control fs-7 @error('date') is-invalid @enderror" name="date"
                    id="inputEmail4" value="{{ old('tanggal', date('Y-m-d')) }}">
                @error('date')
                    <div class="invalid-feedback fs-8">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12">
                <label for="inputEmail4" class="form-label fs-7">Catatan</label>
                <textarea name="notes" id="" cols="30" rows="10" class="form-control fs-7">{{ old('notes') }}</textarea>
                @error('notes')
                    <div class="invalid-feedback fs-8">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12">
                <label for="inputEmail4" class="form-label fs-7">Bukti Bayar (.png, .jpg)</label>
                <input type="file" class="form-control fs-7 @error('image') is-invalid @enderror" name="image"
                    accept="image/*" id="inputEmail4" placeholder="Jumlah">
                @error('image')
                    <div class="invalid-feedback fs-8">{{ $message }}</div>
                @enderror
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success fs-7">Tambah</button>
                <a href="{{ route('category.index') }}" class="btn btn-danger fs-7">Batal</a>
            </div>
        </form>
    </div>
@endsection
@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl/1.2.5/Intl.min.js"
        integrity="sha512-/ArHcCxOUEzVJqTclr4BXgOh822PkcTim88bqb4EBKnn71lsbIjdZzRJb2+/zI0EWrcOTYnDCBrN2/5luFwf5A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('assets/js/reports.js') }}"></script>
@endsection
