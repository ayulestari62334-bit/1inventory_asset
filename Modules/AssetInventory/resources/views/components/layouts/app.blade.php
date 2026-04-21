<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Inventory Asset')</title>

    {{-- AdminLTE --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    {{-- NAVBAR --}}
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-danger btn-sm">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </li>
        </ul>
    </nav>

    {{-- SIDEBAR --}}
    @php
        $masterActive = request()->is(
            'kategori-barang*',
            'jenis-barang*',
            'lokasi*',
            'warna*',
            'merek*'
        );
    @endphp

    <aside class="main-sidebar sidebar-light-primary elevation-2">
        <a href="{{ route('dashboard') }}" class="brand-link">
            <i class="fas fa-boxes ml-2"></i>
            <span class="brand-text font-weight-bold ml-2">Inventory Asset</span>
        </a>

        <div class="sidebar">

            {{-- USER PANEL --}}
            <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
                <div class="image">
                    <div class="img-circle bg-primary text-white d-flex align-items-center justify-content-center"
                         style="width:38px;height:38px;font-weight:bold;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ auth()->user()->name }}</a>
                    <small class="text-muted">{{ auth()->user()->role }}</small>
                </div>
            </div>

            {{-- MENU --}}
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column"
                    data-widget="treeview"
                    role="menu"
                    data-accordion="false">

                    {{-- DASHBOARD --}}
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}"
                           class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    {{-- USERS --}}
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}"
                           class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Management User</p>
                        </a>
                    </li>

                    {{-- MASTER DATA --}}
                    <li class="nav-item has-treeview {{ $masterActive ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ $masterActive ? 'active' : '' }}">
                            <i class="nav-icon fas fa-database"></i>
                            <p>
                                Master Data
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{ url('kategori-barang') }}"
                                   class="nav-link {{ request()->is('kategori-barang*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-tags"></i>
                                    <p>Data Kategori</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('jenis-barang') }}"
                                   class="nav-link {{ request()->is('jenis-barang*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-layer-group"></i>
                                    <p>Data Jenis</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('lokasi') }}"
                                   class="nav-link {{ request()->is('lokasi*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-map-marker-alt"></i>
                                    <p>Data Lokasi</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('warna') }}"
                                   class="nav-link {{ request()->is('warna*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-palette"></i>
                                    <p>Data Warna</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('merek') }}"
                                   class="nav-link {{ request()->is('merek*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-industry"></i>
                                    <p>Data Merek</p>
                                </a>
                            </li>

                        </ul>
                    </li>

                    {{-- MANAGEMENT BARANG --}}
                    <li class="nav-item">
                        <a href="{{ url('management-barang') }}"
                           class="nav-link {{ request()->is('management-barang*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-box"></i>
                            <p>Management Barang</p>
                        </a>
                    </li>

                </ul>
            </nav>

        </div>
    </aside>

    {{-- CONTENT --}}
    <div class="content-wrapper p-3">
        @yield('content')
    </div>

</div>

{{-- JS --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
