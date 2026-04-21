<aside class="main-sidebar sidebar-light-primary elevation-4">

    {{-- BRAND --}}
    <a href="{{ route('dashboard') }}" class="brand-link d-flex align-items-center justify-content-center">
        <i class="fas fa-boxes text-primary me-2"></i>
        <span class="brand-text fw-bold">Inventory Asset</span>
    </a>

    <div class="sidebar">

        {{-- USER PANEL --}}
        @auth
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
            <div class="image">
                <div class="img-circle bg-primary text-white d-flex align-items-center justify-content-center"
                     style="width:38px;height:38px;font-weight:bold;">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
            </div>

            <div class="info">
                <a href="#" class="d-block fw-semibold text-dark">{{ auth()->user()->name ?? 'User' }}</a>
                <small class="text-muted">{{ auth()->user()->role ?? '-' }}</small>
            </div>
        </div>
        @endauth

        {{-- MENU --}}
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-legacy"
                data-widget="treeview"
                data-accordion="false">

                {{-- DASHBOARD --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                       class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt text-primary"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- MANAGEMENT USERS --}}
                <li class="nav-item">
                    <a href="{{ route('users.index') }}"
                       class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users text-success"></i>
                        <p>Management Users</p>
                    </a>
                </li>

                {{-- MASTER DATA --}}
                @php
                    $masterActive = request()->is('divisi*') ||
                                    request()->is('karyawan*') ||
                                    request()->is('kategori-barang*') ||
                                    request()->is('jenis-barang*') ||
                                    request()->is('lokasi*') ||
                                    request()->is('warna*') ||
                                    request()->is('merek*');
                @endphp
                <li class="nav-item {{ $masterActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $masterActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-database text-info"></i>
                        <p>
                            Master Data
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('divisi.index') }}"
                               class="nav-link {{ request()->is('divisi*') ? 'active' : '' }}">
                                <i class="fas fa-sitemap nav-icon text-warning"></i>
                                <p>Data Divisi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('karyawan.index') }}"
                               class="nav-link {{ request()->is('karyawan*') ? 'active' : '' }}">
                                <i class="fas fa-user-tie nav-icon text-primary"></i>
                                <p>Data Karyawan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('kategori.index') }}"
                               class="nav-link {{ request()->is('kategori-barang*') ? 'active' : '' }}">
                                <i class="fas fa-tags nav-icon text-danger"></i>
                                <p>Data Kategori</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('jenis.index') }}"
                               class="nav-link {{ request()->is('jenis-barang*') ? 'active' : '' }}">
                                <i class="fas fa-layer-group nav-icon text-info"></i>
                                <p>Data Jenis</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('lokasi.index') }}"
                               class="nav-link {{ request()->is('lokasi*') ? 'active' : '' }}">
                                <i class="fas fa-map-marker-alt nav-icon text-primary"></i>
                                <p>Data Lokasi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('warna.index') }}"
                               class="nav-link {{ request()->is('warna*') ? 'active' : '' }}">
                                <i class="fas fa-palette nav-icon text-warning"></i>
                                <p>Data Warna</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('merek.index') }}"
                               class="nav-link {{ request()->is('merek*') ? 'active' : '' }}">
                                <i class="fas fa-trademark nav-icon text-danger"></i>
                                <p>Data Merek</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- MANAGEMENT BARANG --}}
                @php
                    $barangActive = request()->is('barang*') || request()->is('stock-opname*');
                @endphp
                <li class="nav-item {{ $barangActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $barangActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box text-success"></i>
                        <p>
                            Management Barang
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('barang.index') }}"
                               class="nav-link {{ request()->is('barang*') ? 'active' : '' }}">
                                <i class="fas fa-box-open nav-icon text-primary"></i>
                                <p>Data Barang</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('stock-opname.index') }}"
                               class="nav-link {{ request()->is('stock-opname*') ? 'active' : '' }}">
                                <i class="fas fa-clipboard-check nav-icon text-info"></i>
                                <p>Stock Opname</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>

    </div>
</aside>