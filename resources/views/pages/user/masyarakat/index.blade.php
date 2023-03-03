@extends('layout.app')

@section('css')
@endsection
@php
    $button = false;
    $page_subtitle = true;
@endphp

@section('page_title', 'DATA AKUN MASYARAKAT')
@section('page_subtitle', 'Anda dapat menambah, menghapus, dan menambahkan akun masyarakat baru')
@section('breadcrumb_title', 'User')


@section('body')
    <div class="col-lg-12">
        <div class="row box-container">
            <div class="col-12 d-flex justify-content-between">
                <div class="search-bar">
                    <form class="search-form d-flex align-items-center" method="POST" action="#">
                        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
                    </form>
                </div>
                <div class="">
                    <select class="form-select  fs-7" aria-label="Default select example">
                        <option selected disabled>Pilih kategori user</option>
                        <option value="all">Semua</option>
                        <option value="1">Kec. Ajibata</option>
                        <option value="1">Kec. Balige</option>
                        <option value="1">Kec. Bonatua Lunasi</option>
                    </select>
                </div>
            </div>
            <div class="col-12 mt-4">
                <table class="table fs-7 table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Position</th>
                            <th scope="col">Age</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < 10; $i++)
                            <tr>
                                <th scope="row">{{ $i + 1 }}</th>
                                <td>Brandon Jacob</td>
                                <td>Designer</td>
                                <td>28</td>
                                <td>2016-05-25</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn button btn-warning">Edit</button>
                                        <button class="btn button btn-danger">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
@endsection
