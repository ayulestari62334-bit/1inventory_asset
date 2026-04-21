<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\StockOpnameController;
use App\Http\Controllers\StockOpnameDetailController;

/*
|--------------------------------------------------------------------------
| ROOT REDIRECT
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| GUEST ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard (Semua user bisa)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | USERS
    |--------------------------------------------------------------------------
    */
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    /*
    |--------------------------------------------------------------------------
    | MASTER DATA - SEMUA USER BOLEH LIHAT
    |--------------------------------------------------------------------------
    */

    // ================= DIVISI =================
    Route::prefix('divisi')->name('divisi')->group(function () {
        Route::get('/', [DivisiController::class, 'index'])->name('.index');
    });

    // ================= KARYAWAN =================
    Route::prefix('karyawan')->name('karyawan')->group(function () {
        Route::get('/', [KaryawanController::class, 'index'])->name('.index');
    });

    // ================= BARANG =================
    Route::prefix('barang')->name('barang')->group(function () {
        Route::get('/', [BarangController::class, 'index'])->name('.index');
       
        // ✅ SCAN QR (SEMUA USER BOLEH)
        Route::get('/scan/{id}', [BarangController::class, 'show'])->name('.scan');
        
        // DETAIL BARANG
        Route::get('/{id}', [BarangController::class, 'show'])->name('.show');

        // ✅ ROUTE QR UNTUK SEMUA USER
        Route::get('/qr/{id}', [BarangController::class, 'printQr'])->name('.qr');

    });

    /*
    |--------------------------------------------------------------------------
    | 🔒 KHUSUS FULL ADMINISTRATOR (CRUD + QR PRINT)
    |--------------------------------------------------------------------------
    */
    Route::middleware('admin')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | USERS (CRUD KHUSUS ADMIN)
        |--------------------------------------------------------------------------
        */
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // ================= DIVISI =================
        Route::post('/divisi', [DivisiController::class, 'store'])->name('divisi.store');
        Route::put('/divisi/{id}', [DivisiController::class, 'update'])->name('divisi.update');
        Route::delete('/divisi/{id}', [DivisiController::class, 'destroy'])->name('divisi.destroy');

        // ================= KARYAWAN =================
        Route::post('/karyawan', [KaryawanController::class, 'store'])->name('karyawan.store');
        Route::put('/karyawan/{id}', [KaryawanController::class, 'update'])->name('karyawan.update');
        Route::delete('/karyawan/{id}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');

        // ================= BARANG =================
        Route::delete('/barang/destroy-all', [BarangController::class, 'destroyAll'])->name('barang.destroyAll');

        // ✅ CETAK 1 BARANG (ADMIN SAJA)
        Route::get('/barang/qr/{id}', [BarangController::class, 'printQr'])->name('barang.printQr');

        // ✅ CETAK BEBERAPA BARANG
        Route::post('/barang/qr/multiple', [BarangController::class, 'printMultiple'])->name('barang.printMultiple');

        // ✅ CETAK SEMUA BARANG
        Route::get('/barang/qr-all', [BarangController::class, 'printAll'])->name('barang.printAll');

        Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
        Route::put('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');
        Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | STOCK OPNAME (Semua user boleh akses)
    |--------------------------------------------------------------------------
    */
    Route::prefix('stock-opname')->name('stock-opname')->group(function () {
        // Semua user bisa lihat list & buat stock opname
        Route::get('/', [StockOpnameController::class, 'index'])->name('.index');
        Route::get('/create', [StockOpnameController::class, 'create'])->name('.create');
        Route::post('/', [StockOpnameController::class, 'store'])->name('.store');
        Route::get('/{id}', [StockOpnameController::class, 'show'])->name('.show');

        // ✅ Update detail barang stock opname (semua user boleh)
        Route::post('/update-detail', [StockOpnameDetailController::class, 'update'])->name('.updateDetail');

        // ✅ Close stock opname (hanya admin)
        Route::post('/close/{id}', [StockOpnameController::class, 'close'])->name('.close');

        // Hapus stock opname (admin)
        Route::delete('/{id}', [StockOpnameController::class, 'destroy'])->name('.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

