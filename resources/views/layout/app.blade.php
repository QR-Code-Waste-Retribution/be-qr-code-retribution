@include('layout.header')

@include('layout.sidebar')
<main id="main" class="main">
    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">@yield('breadcrumb_title')</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-8 d-flex justify-content-start align-items-start flex-column">
                <h1>@yield('page_title')</h1>
                <p class="mt-1 fs-7">@yield('page_subtitle')</p>
            </div>
            @if ($button ?? false)
                <div class="col-4 d-flex justify-content-end align-items-center">
                    <a class="button-primary text-center"><i class="bi bi-plus-circle-fill"></i>&nbsp; Tambah Akun Baru</a>
                </div>
            @endif
        </div>
    </div>
    <hr>
    <section class="section dashboard">
        <div class="row">
            @yield('body')
        </div>
    </section>

</main><!-- End #main -->

@include('layout.footer')
