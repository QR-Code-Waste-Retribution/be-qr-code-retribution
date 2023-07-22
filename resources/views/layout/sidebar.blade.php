<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center">
            <img src="{{ asset('assets/img/logo-' . strtolower(auth()->user()->district->name) .  '.png') }}" alt="">
            <span class="d-none d-lg-block fs-6 ">Dinas Lingkungan Hidup Kabupaten {{ auth()->user()->district->name }}</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>
            </li>

            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="{{ asset('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ auth()->user()->name }}</span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{ auth()->user()->name }}</h6>
                        <span
                            class="text-capitalize">{{ implode(' ', explode('_', auth()->user()->role->name)) . ' ' . auth()->user()->district->name }}</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="{{ route('dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav-user" data-bs-toggle="collapse"
                href="#">
                <i class="bi bi-menu-button-wide"></i><span>Data User</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav-user" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('masyarakat.index') }}">
                        <i class="bi bi-circle"></i><span>Masyarakat</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pemungut.index') }}">
                        <i class="bi bi-circle"></i><span>Petugas Pemungut</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Components Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav-transaction" data-bs-toggle="collapse"
                href="#">
                <i class="bi bi-menu-button-wide"></i><span>Data Transaksi</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav-transaction" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#components-nav-non-confirmation"
                        data-bs-toggle="collapse" href="#">
                        <i class="bi bi-menu-button-wide"></i><span>Menunggu konfirmasi</span><i
                            class="bi bi-chevron-down ms-auto fs-6 me-2"></i>
                    </a>
                    <ul id="components-nav-non-confirmation" class="nav-content collapse">
                        <li class="ms-3">
                            <a href="{{ route('transaction-cash.status.index.wait') }}">
                                <i class="bi bi-circle"></i><span>Pembayaran Tunai</span>
                            </a>
                        </li>
                        <li class="ms-3">
                            <a href="/transaction-noncash-waiting/{{ $payment_via = 'virtual_account' }}/payment">
                                <i class="bi bi-circle"></i><span>Pembayaran Non-Tunai</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                     <a class="nav-link collapsed" data-bs-target="#components-nav-accepted"
                        data-bs-toggle="collapse" href="#">
                        <i class="bi bi-menu-button-wide"></i><span>Sudah diterima</span><i
                            class="bi bi-chevron-down ms-auto fs-6 me-2"></i>
                    </a>
                    <ul id="components-nav-accepted" class="nav-content collapse ">
                        <li class="ms-3">
                            <a href="{{ route('transaction-cash.status.index.confirmed') }}">
                                <i class="bi bi-circle"></i><span>Pembayaran Tunai</span>
                            </a>
                        </li>
                        <li class="ms-3">
                            <a href="{{ route('transaction-noncash.index') }}">
                                <i class="bi bi-circle"></i><span>Pembayaran Non-Tunai</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('category.index') }}">
                <i class="bi bi-person"></i>
                <span>Management Kategori</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('masyarakat.verification') }}">
                <i class="bi bi-person"></i>
                <span>Verifikasi Akun Masyarakat Baru</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('reports.index') }}">
                <i class="bi bi-person"></i>
                <span>Catatan Laporan</span>
            </a>
        </li>
    </ul>
</aside>
