<nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ms-auto">

        @auth
        <li class="nav-item">

            <!-- Tombol logout merah -->
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm px-3 py-1">
                    Logout
                </button>
            </form>

        </li>
        @endauth

    </ul>

</nav>

<!-- CSS tambahan untuk tombol -->
<style>
    .btn-danger {
        font-weight: 600;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .btn-danger:hover {
        background-color: #c82333;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 3px 6px rgba(0,0,0,0.2);
    }
</style>