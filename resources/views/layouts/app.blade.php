<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('title', 'Product-Management')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    @include('partials.style')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        @include('partials.header')
        @include('partials.sidebar')
        <!--begin::App Main-->
        <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">@yield('breadcrumb-title', 'Dashboard')</h3></div>
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@yield('breadcrumb-title', 'Dashboard')</li>
                </ol>
                </div>
            </div>
            <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
            @if (session('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                  {{ session('success') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif

            @if (session('error'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  {{ session('error') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif
            @yield('content')
        </div>
        <!--end::App Content-->
        </main>
        <!--end::App Main-->
        @include('partials.footer')
    </div>
    <!--end::App Wrapper-->
    @include('partials.script')
    @stack('scripts')
  </body>
  <!--end::Body-->
</html>
