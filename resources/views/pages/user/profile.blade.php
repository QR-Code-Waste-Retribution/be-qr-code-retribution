@extends('layout.app')

@section('css')
@endsection

@php
    $page_subtitle = false;
@endphp

@section('page_title', 'Dashboard')
@section('breadcrumb_title', 'User')

@section('body')

@endsection
@section('javascript')
    <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script>
        console.log('Testing')
    </script>
@endsection
