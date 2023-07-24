@include('layout.header')

@include('layout.sidebar')
<main id="main" class="main bg-white">
    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">@yield('breadcrumb_title')</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-8 d-flex justify-content-start align-items-start flex-column">
                <h1>@yield('page_title')</h1>
                @if ($transaction_page_title ?? false)
                    <p class="mt-1 fs-2 fw-semibold text-success">@yield('transaction_page_title')</p>
                @endif
                @if ($page_subtitle ?? false)
                    <p class="mt-1 fs-7">@yield('page_subtitle')</p>
                @endif
            </div>
            @if ($button ?? false)
                <div class="col-4 d-flex justify-content-end align-items-center">
                    <a class="button-primary text-center" href="{{ url()->current() }}/create"><i
                            class="bi bi-plus-circle-fill"></i>&nbsp; @yield('button_text', 'Tambah Akun Baru') </a>
                </div>
            @endif
        </div>
    </div>
    <hr>
    <section class="section dashboard">
        @if (session('status'))
            <div class="alert alert-{{ session('type') }} alert-dismissible fade show" role="alert">
                <h4 class="alert-heading text-capitalize">{{ session('type') == "danger" ? "Error" : session('type') }}</h4>
                <p class="fs-7">{{ session('status') }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row">
            @yield('body')
        </div>
    </section>

</main><!-- End #main -->

@include('layout.footer')
