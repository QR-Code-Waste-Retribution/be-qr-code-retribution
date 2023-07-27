@extends('layout.app')

@section('css')
@endsection

@php
    $page_subtitle = true;
@endphp

@section('page_title', 'DATA TRANSAKSI - Pembayaran Non-Tunai')
@section('page_subtitle',
    'Anda dapat melihat iuran retribusi sampah yang sudah di bayarkan oleh masyarakat di tiap
    kecamatan secara non-tunai')
@section('breadcrumb_title', 'Data Transaksi')

@section('body')
    <div class="col-lg-12">
        <div class="row align-items-center">
            <div class="col-md-6">
                <a class="button-primary text-center px-4" href="{{ route('transaction-noncash.export') }}">Download Excel
                    &nbsp;<i class="bi bi-download"></i></a>
            </div>
        </div>
        <div class="col-12 mt-4">
            <table class="table fs-7 table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" class="w-75">Name</th>
                        <th scope="col">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total_price_transactions = 0;
                    @endphp
                    @foreach ($non_cash_payment as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>
                                <a
                                    href="{{ route('transaction-noncash.sub_district_id', $item->id) }}">
                                    <span class="">Kec. {{ $item->name }}</span>
                                </a>
                            </td>
                            @if (count($item->transactions))
                                @php
                                    $price = (int) collect($item->transactions)->sum('total') - count($item->transactions) * 3500;
                                    $total_price_transactions += $price;
                                @endphp
                                <td>Rp.
                                    {{ number_format($price, 2) }}
                                </td>
                            @else
                                <td>Rp. 0</td>
                            @endif
                        </tr>
                    @endforeach
                    <tr class="fw-bold">
                        <td></td>
                        <td>Total</td>
                        <td>Rp. {{ number_format($total_price_transactions, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('javascript')
@endsection
