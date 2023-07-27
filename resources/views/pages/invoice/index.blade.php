@extends('layout.app')

@section('css')
@endsection
@php
    $page_subtitle = true;
@endphp

@section('page_title', 'TAGIHAN WAJIB RETRIBUSI')
@section('page_subtitle', 'Periksa kesesuaian data dengan tagihan yang akan di dibayarkan oleh masyarakat.')
@section('breadcrumb_title', 'Tagihan')

@section('body')
    <div class="col-lg-12">
        <div class="row box-container">
            <div class="d-flex align-items-center gap-4">
                <button type="button" class="btn btn-warning fs-7 px-3 py-2 my-2 fw-medium" data-bs-toggle="modal"
                    data-bs-target="#notificationModal">
                    <i class="bi bi-bell-fill"></i>
                    &nbsp;
                    Generate Tagihan
                </button>
            </div>

            <div class="col-12">
                <form method="GET" action="{{ route('invoice.index') }}">
                    <div class="d-flex align-items-center gap-4">
                        <div class="search-bar">
                            <div class="search-form d-flex align-items-center">
                                <input type="text" name="search" placeholder="Cari Tagihan" title="Enter search keyword"
                                    value="{{ request()->input('search') }}">
                                <button type="button" title="Search"><i class="bi bi-search"></i></button>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" title="Search"
                                class="btn button-search btn-primary fs-7 px-3 py-2 my-2"><i class="bi bi-search"></i>&nbsp;
                                Search</button>
                        </div>
                        <a class="btn btn-primary fs-7 px-4 py-2 my-2" href="{{ route('invoice.index') }}">Tampilkan
                            semua</a>
                    </div>
                </form>
            </div>
            <div class="col-12 mt-4 table-responsive">
                <table class="table fs-7">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Wajib Retribusi</th>
                            <th scope="col">NIK</th>
                            <th scope="col">Nomor Telepon</th>
                            <th scope="col">Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($invoices as $item)
                            <tr>
                                <td scope="row">{{ (request()->input('page', 1) - 1) * 10 + $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->nik }}</td>
                                <td>{{ $item->phoneNumber }}</td>
                                <td>{{ $item->address }}</td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <div class="container">
                                        <div class="d-flex gap-3 overflow-scroll">
                                            @foreach ($item->invoices as $invoice)
                                                <div class="col-3 h-100 p-3 rounded-3 shadow">
                                                    <p class="m-0 mb-1 fs-8">
                                                        {{ date('d F Y', strtotime($invoice->created_at)) }}
                                                    </p>
                                                    <p class="m-0 mb-1 fw-bold">{{ $invoice->category->name }}
                                                    </p>

                                                    <p class="m-0 mb-1 fs-8 fst-italic">
                                                        {{ $invoice->users_categories->address }}
                                                    </p>

                                                    <p class="m-0 my-1">Rp.
                                                        {{ number_format($invoice->category->price, 2) }} / <span
                                                            class="badge bg-primary">
                                                            {{ $invoice->category->typeTranslation }}</span>
                                                    </p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-danger text-center" colspan="5">Data Tagihan tidak ada</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $invoices->links() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('notification.send.token') }}">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Generate tagihan retribusi</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-2">
                        @csrf
                        <div class="col-12">
                            <label for="inputNanme4" class="form-label fs-8">Judul Notifikasi</label>
                            <input type="text"
                                class="form-control fs-8 @error('title_notification') is-invalid @enderror"
                                name="title_notification" id="inputNanme4" placeholder="Judul Notifikasi"
                                value="{{ 'Pembayaran Retribusi Sampah Kabupaten ' . auth()->user()->district->name }}">
                            @error('title_notification')
                                <div class="invalid-feedback fs-8">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 mt-3">
                            <label for="inputEmail4" class="form-label fs-8">Deskripsi Notifikasi</label>
                            <textarea name="description_notification" id="" cols="30" rows="10"
                                class="form-control fs-8 @error('description_notification') is-invalid @enderror" name="description_notification"
                                id="inputEmail4" placeholder="Deskripsi">Halo Wajib Retribusi, jangan lupa untuk melakukan pembayaran tagihan retribusi sampah anda bulan ini</textarea>
                            @error('description_notification')
                                <div class="invalid-feedback fs-8">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary fs-7" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary fs-7">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    @if (session('title_notification'))
        <script>
            $('#notificationModal').show();
        </script>
    @endif
@endsection
