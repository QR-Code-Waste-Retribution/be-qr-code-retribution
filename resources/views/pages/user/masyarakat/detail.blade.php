@extends('layout.app')

@section('css')
    <style>
        .detail-transaction td {
            padding-top: 10px;
            padding-bottom: 10px;
            padding-right: 10px;
        }
    </style>
@endsection

@php
    $page_subtitle = false;
@endphp

@section('page_title', 'DATA AKUN MASYARAKAT')
@section('breadcrumb_title', 'AKUN MASYARAKAT')

@section('body')
    <div class="col-lg-12 detail-transaction">
        <table>
            <tbody class="fs-7">
                <tr>
                    <td>Nama Petugas</td>
                    <td>:</td>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>:</td>
                    <td>{{ $user->gender }}</td>
                </tr>
                <tr>
                    <td>Nomor Telepon</td>
                    <td>:</td>
                    <td>{{ $user->phoneNumber }}</td>
                </tr>
                <tr>
                    <td>Kecamatan</td>
                    <td>:</td>
                    <td>{{ $user->sub_district->name }}</td>
                </tr>
                <tr>
                    <td>Kabupaten</td>
                    <td>:</td>
                    <td>{{ $user->district->name }}</td>
                </tr>
            </tbody>
        </table>

        <table class="mt-4 table table-striped table-hover table-bordered">
            <thead class="fs-7">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Tipe Pembayaran Retribusi</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Kecamatan</th>
                    <th scope="col">Pemungut</th>
                </tr>
            </thead>
            <tbody class="fs-7">
                @foreach ($user->masyarakat_category as $item)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $item->category->name }}</td>
                        <td>Rp. {{ number_format($item->category->price, 2) }}</td>
                        <td>
                            <span class="badge bg-primary">{{ $item->category->type_translation }}</span>
                        </td>
                        <td>{{ $item->address }}</td>
                        <td>Kec. {{ $item->subdistrict->name }}</td>
                        <td>
                            {{ $item->pemungut->name }} <br> 
                            <span class="fs-8 fst-italic">{{ $item->pemungut->phoneNumber }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('javascript')
@endsection
