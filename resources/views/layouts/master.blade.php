<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        {{ isset($settings['lang_title']) ? $settings['lang_title'] : (isset($lang['lang_title']) ? $lang['lang_title'] : 'Dashboard') }}
    </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('modules/kody2/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="icon" href="{{ asset('modules/kody2/assets/favicon/favicon.png') }}" type="image/ico">

    <link rel="stylesheet" href="{{ asset('modules/kody2/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('modules/kody2/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('modules/kody2/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Theme style -->
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('modules/kody2/dist/css/ionicons.min.css') }}">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('modules/kody2/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('modules/kody2/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('modules/kody2/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('modules/kody2/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/kody2/dist/css/animate.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('modules/kody2/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('modules/kody2/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('modules/kody2/plugins/summernote/summernote-bs4.css') }}">
    <link href="{{ asset('modules/kody2/plugins/hadi/google.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('modules/kody2/dist/css/bootstrap4.2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('modules/kody2/dist/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/kody2/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('modules/kody2/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link href="{{ asset('modules/kody2/dist/css/hadianime.css') }}" rel="stylesheet">
    <link href="{{ asset('modules/kody2/dist/css/horstec.css') }}" rel="stylesheet">
    <link href="{{ asset('modules/kody2/styles/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('modules/kody2/styles/sidebar-fixes.css') }}" rel="stylesheet">
    <link href="{{ asset('native/css/operations_responsive.css') }}" rel="stylesheet">

    <!-- إصلاح طوارئ السايد بار -->
    <style>
        body .wrapper .main-sidebar .nav-sidebar .nav-link:hover {
            background: linear-gradient(135deg, #eff6ff, #dbeafe) !important;
            color: #1e40af !important;
            transform: translateX(3px) scale(1.02) !important;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25) !important;
            border-radius: 12px !important;
            transition: all 0.3s ease !important;
        }

        body .wrapper .main-sidebar .nav-sidebar .nav-link:hover .nav-icon {
            color: #2563eb !important;
            transform: scale(1.15) rotate(5deg) !important;
        }

        .content-wrapper {
            background-color: {{ isset($settings['bodycolor']) ? $settings['bodycolor'] : '#f4f6f9' }};
        }

        .nav-link {
            color: black !important;
            border: 1;
        }

        .content-wrapper {
            background-color: {{ isset($settings['bodycolor']) ? $settings['bodycolor'] : '#f4f6f9' }};
        }

        /* Font Awesome Font Faces */
        @font-face {
            font-family: "Font Awesome 5 Free";
            font-style: normal;
            font-weight: 900;
            font-display: block;
            src: url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/webfonts/fa-solid-900.woff2") format("woff2");
        }

        @font-face {
            font-family: "Font Awesome 5 Free";
            font-style: normal;
            font-weight: 400;
            font-display: block;
            src: url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/webfonts/fa-regular-400.woff2") format("woff2");
        }

        @font-face {
            font-family: "Font Awesome 5 Brands";
            font-style: normal;
            font-weight: 400;
            font-display: block;
            src: url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/webfonts/fa-brands-400.woff2") format("woff2");
        }

        /* CRITICAL FIX: Force Font Awesome to work */
        i.fa,
        i.fas,
        i.far,
        i.fab,
        i.fal,
        i.fad,
        span.fa,
        span.fas,
        span.far,
        span.fab,
        span.fal,
        span.fad,
        .fa,
        .fas,
        .far,
        .fab,
        .fal,
        .fad {
            font-family: "Font Awesome 5 Free" !important;
            font-weight: 900 !important;
            font-style: normal !important;
            font-variant: normal !important;
            text-rendering: auto !important;
            -webkit-font-smoothing: antialiased !important;
            -moz-osx-font-smoothing: grayscale !important;
            display: inline-block !important;
            direction: ltr !important;
        }

        .far {
            font-weight: 400 !important;
        }

        .fab {
            font-family: "Font Awesome 5 Brands" !important;
            font-weight: 400 !important;
        }

        body {
            font-family: 'Cairo', sans-serif !important;
            font-weight: 600 !important;
            font-size: 15px !important;
        }
    </style>

    <script src="{{ asset('modules/kody2/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('modules/kody2/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('modules/kody2/dist/modal/modal.js') }}"></script>
    <script src="{{ asset('modules/kody2/dist/css/tailwind.js') }}"></script>
    @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('dashboard.navbar')
        @include('dashboard.sidebar')

        <div class="content-wrapper">
            @yield('content')
        </div>

        @include('dashboard.footer')
    </div>
    @stack('scripts')
</body>

</html>
