@extends('layout.app')

@section('css')
@endsection

@php
    $page_subtitle = true;
@endphp

@section('page_title', 'DATA TRANSAKSI - Pembayaran Tunai')
@section('page_subtitle', 'Anda dapat melihat iuran retribusi sampah yang sudah di kumpulkan oleh petugas pemungut')
@section('breadcrumb_title', 'Data Transaksi')

@section('body')
    <div class="col-lg-12">
        <div class="row align-items-center box-container">
            <div class="col-4">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">Target Pemasukan <span>| Bulan Ini</span></h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                            <div class="ps-3">
                                @if (!isset($invoice_monthly['unpaid']) && isset($invoice_monthly['paid']))
                                    <h6 class="fs-4">Rp.
                                        {{ number_format($invoice_monthly['paid']['total'] ?? 0, 2) }}
                                        -,</h6>
                                @elseif(!isset($invoice_monthly['paid']) && isset($invoice_monthly['unpaid']))
                                    <h6 class="fs-4">Rp.
                                        {{ number_format($invoice_monthly['unpaid']['total'] ?? 0, 2) }}
                                        -,</h6>
                                @elseif(!isset($invoice_monthly['paid']) && !isset($invoice_monthly['unpaid']))
                                    <h6 class="fs-4">Rp.
                                        {{ 0 }}
                                        -,</h6>
                                @else
                                    <h6 class="fs-4">Rp. 
                                        {{ number_format($invoice_monthly['unpaid']['total'] ?? 0 + $invoice_monthly['paid']['total'] ?? 0, 2) }}
                                        -,</h6>
                                @endif
                                <span class="text-success small pt-1 fw-bold"></span><span
                                    class="text-muted small pt-2 ps-1">21 Februari 2023</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            @error('input_count')
            <div class="alert alert-danger text-center">
                <span class="fw-semibold"> &#9888; Anda belum memilih pembayaran!</span>
            </div>
            @enderror
            <div class="py-3 d-flex align-items-center" id="selected-item-confirmation-container">
                
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        <span>{{session('success')}}</span>
                    </div>
                @endif
    
                <div class="w-100 bg-warning p-2 rounded text-center me-2">
                    <span class=""><strong id="select-items-count">0</strong> Pembayaran telah dipilih</span>
                </div>
                <div>
                    <button data-bs-toggle="modal" data-bs-target="#modal-confirmation-selected" class="btn btn-success">Konfirmasi</button>
                </div>
            </div>

            <div class="col-md-12">
                <a class="button-primary text-center px-4" href="{{ route('transaction-cash.export') }}">Download Excel
                    &nbsp;<i class="bi bi-download"></i></a>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-12">
                        <form method="GET" action="{{ route('transaction-cash.status.index', ['status' => $status]) }}">
                            <div class="d-flex justify-content-between gap-5 align-items-center">
                                <div class="search-bar">
                                    <div class="search-form d-flex align-items-center mt-4">
                                        <input type="text" name="search" placeholder="Cari nama atau nomor telepon"
                                            title="Enter search keyword" value="{{ request()->input('search') }}">
                                        <button type="button" title="Search"><i class="bi bi-search"></i></button>
                                    </div>
                                </div>
                                <x-month-select col="3" />
                                <x-sub-district-dropdown col="3" />
                            </div>
                            <div class="w-100 d-flex justify-content-end">
                                <button type="submit" title="Search"
                                    class="btn button-search btn-primary fs-7 px-3 py-2 my-2"><i
                                        class="bi bi-search"></i>&nbsp; Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-12 mt-4">
            <table class="table fs-7 table-hover">
                <thead>
                    <tr>
                        <th>
                            <div class="d-flex align-items-center">
                                <input type="checkbox" class="form-check" id="select-all" onclick={checkAll()}>
                                <label for="select-all" class="fw-light ms-1">Pilih</label>
                            </div>
                        </th>
                        <th scope="col">Nama Petugas</th>
                        <th scope="col">Lokasi Bertugas</th>
                        <th scope="col">Waktu</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pemungut_transactions as $item)
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check select-items" onclick="check_item(event)" value="{{$item->id}}">
                            </td>
                            <td>
                                <a class="" href="{{ route('transaction-cash.show', $item->id) }}">
                                    <span class="fw-semibold">{{ $item->name }}</span>
                                </a>
                            </td>
                            <td scope="row">
                                Kec. {{ $item->sub_district->name }}
                            </td>
                            <td>Rp.
                                {{ number_format(
                                    $item->pemungut_transactions->sum(function ($user) {
                                        return $user->masyarakat_transactions->sum('price');
                                    }),
                                    2,
                                ) }}
                            </td>
                            <td>
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modal-confirmation-{{$item->id}}">Konfirmasi</button>
                                {{-- {{ \App\Models\PemungutTransaction::getRangeArreas($item->pemungut_transactions) }} --}}
                            </td>
                        </tr>

                        {{-- Modal confirmation --}}
                        <div class="modal fade" id="modal-confirmation-{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body text-center">
                                <div class="p-4">
                                    <h5 class="fw-semibold text-secondary">Apakah Pembayaran {{$item->name}} senilai Rp. {{ number_format(
                                        $item->pemungut_transactions->sum(function ($user) {
                                            return $user->masyarakat_transactions->sum('price');
                                        }),
                                        2,
                                    ) }}  akan dikonfirmasi?</h5>
                                </div>
                                    <img src="{{asset('/assets/img/konfirmasiii 1.png')}}" alt="">
                                </div>
                                <div class="modal-footer d-flex justify-content-center mt-2">
                                    <form method="POST" action="/transaction-cash-waiting/payment/confirmation/{{$item->pemungut_transactions->first()->id}}">
                                        @csrf
                                        {{$item}}
                                        <button type="submit" class="btn btn-sm btn-success px-4" data-bs-dismiss="modal">Ya</button>
                                    </form>
                                    <button type="button" class="btn btn-sm btn-danger px-4" data-bs-dismiss="modal">Tidak</button>
                                </div>
                            </div>
                            </div>
                        </div>

                        {{-- Modal confirmation selected--}}
                        <div class="modal fade" id="modal-confirmation-selected" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body text-center">
                                <div class="p-4">
                                    <h5 class="fw-semibold text-secondary">
                                        Konfirmasi seluruh pembayaran yang telah dipilih?
                                    </h5>
                                </div>
                                    <img src="{{asset('/assets/img/konfirmasiii 1.png')}}" alt="">
                                </div>
                                <div class="modal-footer d-flex justify-content-center mt-2">
                                    <form method="POST" action="/transaction-cash-waiting/payment/confirmation/selected">
                                        @csrf
                                        <input type="hidden" id="input-count" name="input_count">
                                        <button type="submit" class="btn btn-sm btn-success px-4" data-bs-dismiss="modal">Ya</button>
                                    </form>
                                    <button type="button" class="btn btn-sm btn-danger px-4" data-bs-dismiss="modal">Tidak</button>
                                </div>
                            </div>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td>
                                <p class="text-danger fs-7">-</p>
                            </td>
                            <td>
                                <p class="text-danger fs-7">-</p>
                            </td>
                            <td>
                                <p class="text-danger fs-7">-</p>
                            </td>
                            <td>
                                <p class="text-danger fs-7">-</p>
                            </td>
                            <td>
                                <p class="text-danger fs-7">-</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $pemungut_transactions->onEachSide(5)->links() }}
        </div>
    </div>
@endsection
@section('javascript')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script>
        const select_all = document.getElementById('select-all');
        const select_items = document.querySelectorAll('.select-items')
        const select_items_count = document.getElementById('select-items-count')
        const input_count = document.getElementById('input-count');
        const selected_item_area = document.getElementById('selected-item-confirmation-container')
        console.log(select_items)
        var checked_items = [];
        selected_item_area.classList.add('d-none');

        function update_items_count(){
            select_items_count.innerHTML = Object.keys(checked_items).length
            input_count.value = checked_items
            if(checked_items.length > 0){
                selected_item_area.classList.remove('d-none');
            }
            console.log(input_count)
        }

        function check_item(event) {
            if (event.target.checked === true) {
                checked_items.push(event.target.value);
                update_items_count();
                console.log(checked_items);
            } else {
                if (checked_items.indexOf(event.target.value) !== -1) {
                    console.log("not checked");
                    checked_items.splice(checked_items.indexOf(event.target.value), 1);
                    update_items_count();
                    console.log(checked_items);
                }
            }
        }

        function checkAll() {
            if (select_all.checked){
                select_items.forEach(e => {
                    e.checked = true
                    if (checked_items.indexOf(e.value) === -1) {
                        checked_items.push(e.value);
                    }
                    update_items_count()
                });
            }else{
                select_items.forEach(e => {
                    e.checked = false
                    checked_items.splice(checked_items.indexOf(e.value), 1)
                    update_items_count()
                });
            }
        }   

    </script>
@endsection
