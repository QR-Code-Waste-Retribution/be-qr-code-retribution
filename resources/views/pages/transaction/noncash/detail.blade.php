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
        <div class="col-12 mt-4">
            <table class="table fs-7 table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" class="w-25">Nama Wajib Retribusi</th>
                        <th scope="col" class="w-25">Channel Pembayaran</th>
                        <th scope="col" class="w-25">Nomor Tagihan</th>
                        <th scope="col" class="w-25">Nomor Transaksi</th>
                        <th scope="col" class="w-25">Tanggal Transaksi</th>
                        <th scope="col" class="w-25">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($non_cash_data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>
                                @if (isset($item->directApi))
                                    <span class="badge bg-primary">
                                        {{ $item->directApi->bank_name }} ({{ $item->directApi->bank_name_short }})
                                    </span>
                                @endif
                                @if (isset($item->checkout))
                                    @php
                                        $payment_methods = json_encode($item->checkout->payment_method_types);
                                    @endphp
                                    @foreach ($payment_methods as $item)
                                        <span class="badge bg-danger text-uppercase">
                                            {{ $item }}
                                        </span>
                                    @endforeach
                                @endif
                                @if (!isset($item->directApi) && !isset($item->checkout))
                                    <p class="fs-8 fst-italic text-danger text-uppercase">Not Set</p>
                                @endif
                            </td>
                            <td>{{ $item->invoice_number }}</td>
                            <td>{{ $item->transaction_number }}</td>
                            <td>{{ date('d F Y', strtotime($item->created_at)) }}</td>
                            <td>Rp. {{ number_format($item->price, 2) }} <span class="fs-8 fst-italic text-danger">(+3500)
                                    Biaya layanan</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <p class="text-center text-danger">Data transaksi belum ada</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $non_cash_data->links() }}
        </div>
    </div>
@endsection
@section('javascript')
@endsection
