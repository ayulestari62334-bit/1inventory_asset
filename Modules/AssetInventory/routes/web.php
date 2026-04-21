<?php

use Illuminate\Support\Facades\Route;
use Modules\AssetInventory\app\Http\Controllers\KategoriBarangController;
use Modules\AssetInventory\app\Http\Controllers\JenisBarangController;
use Modules\AssetInventory\app\Http\Controllers\LokasiController;
use Modules\AssetInventory\app\Http\Controllers\WarnaController;
use Modules\AssetInventory\app\Http\Controllers\MerekController;

/*
|--------------------------------------------------------------------------
| ASSET INVENTORY ROUTES (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::prefix('kategori-barang')->name('kategori.')->group(function () {
        Route::get('/', [KategoriBarangController::class, 'index'])->name('index');
        Route::post('/', [KategoriBarangController::class, 'store'])->name('store');
        Route::put('/{id}', [KategoriBarangController::class, 'update'])->name('update');
        Route::delete('/{id}', [KategoriBarangController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('jenis-barang')->name('jenis.')->group(function () {
        Route::get('/', [JenisBarangController::class, 'index'])->name('index');
        Route::post('/', [JenisBarangController::class, 'store'])->name('store');
        Route::put('/{id}', [JenisBarangController::class, 'update'])->name('update');
        Route::delete('/{id}', [JenisBarangController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('lokasi')->name('lokasi.')->group(function () {
        Route::get('/', [LokasiController::class, 'index'])->name('index');
        Route::post('/', [LokasiController::class, 'store'])->name('store');
        Route::put('/{id}', [LokasiController::class, 'update'])->name('update');
        Route::delete('/{id}', [LokasiController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('warna')->name('warna.')->group(function () {
        Route::get('/', [WarnaController::class, 'index'])->name('index');
        Route::post('/', [WarnaController::class, 'store'])->name('store');
        Route::put('/{id}', [WarnaController::class, 'update'])->name('update');
        Route::delete('/{id}', [WarnaController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('merek')->name('merek.')->group(function () {
        Route::get('/', [MerekController::class, 'index'])->name('index');
        Route::post('/', [MerekController::class, 'store'])->name('store');
        Route::put('/{id}', [MerekController::class, 'update'])->name('update');
        Route::delete('/{id}', [MerekController::class, 'destroy'])->name('destroy');
    });

});
