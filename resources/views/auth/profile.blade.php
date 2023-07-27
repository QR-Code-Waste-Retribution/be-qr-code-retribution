@extends('layout.app')

@section('css')
@endsection
@php
    $page_subtitle = true;
@endphp

@section('page_title', 'Profile')
@section('page_subtitle', '')
@section('breadcrumb_title', 'profile')

@section('body')
    <div class="col-lg-12">
        <a class="btn btn-warning fs-7" href="{{ route('user.change.password') }}"><i class="bi bi-pencil-square"></i> Ganti Password</a>

        <div class="mt-4">
            <p class="fs-7 m-0">Nama :</p>
            <p class="fs-7 fw-medium m-0">{{ auth()->user()->name }}</p>
            <p class="fs-7 m-0 mt-3">Nomor Telepon :</p>
            <p class="fs-7 fw-medium m-0">{{ auth()->user()->phoneNumber }}</p>
            <p class="fs-7 m-0 mt-3">Kabupaten :</p>
            <p class="fs-7 fw-medium m-0">{{ auth()->user()->district->name }}</p>
        </div>
    </div>
@endsection
@section('javascript')
@endsection
