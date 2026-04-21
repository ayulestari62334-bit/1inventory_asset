<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Bootstrap (BASE UI) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <!-- VITE (TAILWIND + CUSTOM CSS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- STACK STYLE -->
    @stack('styles')

    <!-- ===== CUSTOM GLOBAL STYLE ===== -->
    <style>

        body {
            background-color: #f8fafc;
        }

        /* ===== DASHBOARD CARD ===== */
        .dashboard-card {
            border-radius: 14px !important;
            background: #ffffff !important;
            box-shadow: 0 6px 18px rgba(0,0,0,0.06) !important;
            transition: all 0.25s ease;
            border: none !important;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
        }

        /* ICON BULAT */
        .icon-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }

        /* SOFT BACKGROUND */
        .bg-primary-soft { background: #eff6ff !important; }
        .bg-success-soft { background: #ecfdf5 !important; }
        .bg-warning-soft { background: #fffbeb !important; }
        .bg-danger-soft { background: #fee2e2 !important; }

        /* ===== TABLE ===== */
        .table thead th {
            background-color: #2563eb !important;
            color: #ffffff !important;
            border: none;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f5f9;
        }

        .table td:first-child,
        .table th:first-child {
            width: 60px;
            text-align: center;
        }

        /* ===== BUTTON AKSI ===== */
        .btn-aksi {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            margin-right: 3px;
            transition: 0.2s;
        }

        .btn-aksi:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        /* ===== NAVBAR USER ===== */
        .navbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-user span {
            font-weight: 500;
            color: #fff;
        }

        .navbar-user .btn-logout {
            background-color: #ef4444;
            border: none;
            color: #fff;
            padding: 5px 10px;
            border-radius: 6px;
            font-weight: 600;
        }

        .navbar-user .btn-logout:hover {
            background-color: #dc2626;
        }

        /* ===== CONTENT ===== */
        .content-wrapper {
            background: #f8fafc;
        }

        .content-wrapper .container-fluid {
            padding-top: 20px;
            padding-bottom: 20px;
        }

    </style>

</head>

<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">

    {{-- NAVBAR --}}
    @include('layouts.navigation')

    {{-- SIDEBAR --}}
    @include('partials.sidebar')

    <!-- CONTENT -->
    <div class="content-wrapper">

        {{-- HEADER --}}
        @isset($header)
        <section class="content-header">
            <div class="container-fluid">
                {{ $header }}
            </div>
        </section>
        @endisset

        {{-- MAIN CONTENT --}}
        <section class="content">
            <div class="container-fluid">

                @hasSection('content')
                    @yield('content')
                @elseif(isset($slot))
                    {{ $slot }}
                @endif

            </div>
        </section>

    </div>

</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- AdminLTE -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

@stack('scripts')

</body>
</html>