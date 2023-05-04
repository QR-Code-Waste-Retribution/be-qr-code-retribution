@extends('layout.app')

@section('css')
@endsection

@php
    $page_subtitle = false;
@endphp

@section('page_title', 'Dashboard')
@section('breadcrumb_title', 'Dashboard')

@section('body')
    <!-- Left side columns -->
    <div class="col-lg-12">
        <div class="row">
            <div class="col-12">
                <p class="fw-bold">Informasi keuangan retribusi bulanan</p>
                <div class="row">

                    <!-- Revenue Card -->
                    <div class="col-xxl-3 col-md-5">
                        <a href="{{ route('dashboard.income') }}">
                            <div class="card info-card revenue-card" data-bs-toggle="tooltip" data-bs-placement="right"
                                data-bs-custom-class="custom-tooltip"
                                data-bs-title="Klik untuk melihat lebih detail pemasukan">
                                <div class="card-body">
                                    <h5 class="card-title">Pemasukan <span>| Bulan Ini</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-currency-dollar"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 class="fs-4">Rp.
                                                {{ number_format($invoice_monthly['paid']['total'], 2) }} -,</h6>
                                            <span class="text-success small pt-1 fw-bold"></span><span
                                                class="text-muted small pt-2 ps-1">{{ $invoice_monthly['paid']['date'] }}</span>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </a>
                    </div><!-- End Revenue Card -->

                    <!-- Revenue Card -->
                    <div class="col-xxl-3 col-md-5">
                        <a href="{{ route('dashboard.income') }}">
                            <div class="card info-card revenue-card" data-bs-toggle="tooltip" data-bs-placement="right"
                                data-bs-custom-class="custom-tooltip"
                                data-bs-title="Klik untuk melihat lebih detail pemasukan">
                                <div class="card-body">
                                    <h5 class="card-title">Total yang harus tercapai di Bulan Ini</h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-currency-dollar"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 class="fs-4">Rp.
                                                {{ number_format($invoice_monthly['unpaid']['total'], 2) }} -,</h6>
                                            <span class="text-success small pt-1 fw-bold"></span><span
                                                class="text-muted small pt-2 ps-1">{{ $invoice_monthly['unpaid']['date'] }}</span>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </a>
                    </div><!-- End Revenue Card -->

                </div>
            </div>
            <div class="col-12">
                <p class="fw-bold">Informasi keuangan retribusi tambahan:</p>
                <div class="row">
                    <!-- Revenue Card -->
                    <div class="col-xxl-3 col-md-5">
                        <a href="{{ route('dashboard.income') }}">
                            <div class="card info-card revenue-card" data-bs-toggle="tooltip" data-bs-placement="right"
                                data-bs-custom-class="custom-tooltip"
                                data-bs-title="Klik untuk melihat lebih detail pemasukan">
                                <div class="card-body">
                                    <h5 class="card-title">Pemasukan <span>| Bulan Ini</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-currency-dollar"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 class="fs-4">Rp.
                                                {{ number_format($income['cash'] + $income['noncash'], 2) }} -,</h6>
                                            <span class="text-success small pt-1 fw-bold"></span><span
                                                class="text-muted small pt-2 ps-1">21 Februari 2023</span>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </a>
                    </div><!-- End Revenue Card -->
                </div>
            </div>
            <div class="col-12">
                <p class="fw-bold">Total uang yang terkumpul di bulan ini:</p>
                <div class="row">
                    <!-- Revenue Card -->
                    <div class="col-xxl-3 col-md-4">
                        <a href="{{ route('dashboard.income') }}">
                            <div class="card info-card revenue-card" data-bs-toggle="tooltip" data-bs-placement="right"
                                data-bs-custom-class="custom-tooltip"
                                data-bs-title="Klik untuk melihat lebih detail pemasukan">
                                <div class="card-body">
                                    <h5 class="card-title">Pemasukan <span>| Bulan Ini</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-currency-dollar"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 class="fs-4">Rp.
                                                {{ number_format($income['cash'] + $income['noncash'], 2) }} -,</h6>
                                            <span class="text-success small pt-1 fw-bold"></span><span
                                                class="text-muted small pt-2 ps-1">21 Februari 2023</span>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </a>
                    </div><!-- End Revenue Card -->

                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-5">
                        <h5 class="card-title text-center fs-6">$ Tunai
                        </h5>
                        <div class="d-flex">
                            <div class="card info-card sales-card pt-4 card-dashboard col-md-6">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="p-0">
                                            <span class="text-success small pt-1 fw-bold"></span> <span
                                                class="text-muted small pt-2">Sudah Disetor</span>
                                            <h6 class="fs-5">Rp. {{ number_format($income['cash'], 2) }} -,</h6>
                                            <span class="text-success small pt-1 fw-bold"></span> <span
                                                class="text-muted small pt-2">21
                                                Februari 2023</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card info-card sales-card pt-4 card-dashboard col-md-6"
                                style="background-color: #55a63088">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="p-0">
                                            <span class="text-success small pt-1 fw-bold"></span> <span
                                                class="text-muted small pt-2">Belum Disetor</span>
                                            <h6 class="fs-5">Rp. {{ number_format($income['cash'], 2) }} -,</h6>
                                            <span class="text-success small pt-1 fw-bold"></span> <span
                                                class="text-muted small pt-2">21
                                                Februari 2023</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Sales Card -->
                    <div class="col-xxl-4 col-md-3">
                        <h5 class="card-title text-center fs-6">$ Non-Tunai</h5>
                        <div class="card info-card sales-card pt-4 card-dashboard">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="p-0">
                                        <h6 class="fs-5">Rp. {{ number_format($income['noncash'], 2) }} -,</h6>
                                        <span class="text-success small pt-1 fw-bold"></span> <span
                                            class="text-muted small pt-2 ps-1">21 Februari 2023</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Sales Card -->
                </div>
            </div>
        </div>
    </div><!-- End Left side columns -->

    <!-- Right side columns -->
    <div class="col-lg-12">
        <p class="fs-6">Grafik pemasukan atau iuaran retribusi sampah yang terkumpul tiap bulannya di kabupaten Toba</p>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Line Chart</h5>

                    <!-- Line Chart -->
                    <canvas id="lineChart" style="max-height: 400px;"></canvas>
                    <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            new Chart(document.querySelector('#lineChart'), {
                                type: 'line',
                                data: {
                                    labels: @json($graph['months']),
                                    datasets: [{
                                        label: 'Pemasukan',
                                        data: @json($graph['income']),
                                        fill: false,
                                        borderColor: 'rgb(75, 192, 192)',
                                        tension: 0.1
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        });
                    </script>
                    <!-- End Line CHart -->

                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <p>Jumlah wajib retribusi dan petugas pemungut yang sudah terdaftar dalam Sistem Retribusi Sampah Kabupaten
                Toba:</p>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="d-flex">
                        <div class="icon-dashboard">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="icon-title p-2 px-3">
                            <p class="fw-bold">Masyarakat</p>
                            <p class="fs-5">{{ $users[0]->total }}</p>
                            <small>Update: Februari 2023</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="d-flex">
                        <div class="icon-dashboard">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="icon-title p-2 px-3">
                            <p class="fw-bold">Petugas Pemungut</p>
                            <p class="fs-5">{{ $users[1]->total }}</p>
                            <small>Update: Februari 2023</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Right side columns -->
@endsection
@section('javascript')
    <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script>
        console.log('Testing')
    </script>
@endsection
