<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Barang;
use App\Models\StockOpname;

class DashboardController extends Controller
{
   public function index()
{
    $totalUser   = User::count();
    $totalBarang = Barang::count();
    $totalSTO    = StockOpname::count();

    $sangatLayak = Barang::where('status_barang', 'Sangat Layak')->count();
    $cukupLayak  = Barang::where('status_barang', 'Cukup Layak')->count();
    $layakPakai  = Barang::where('status_barang', 'Layak Pakai')->count();
    $rusak       = Barang::where('status_barang', 'Rusak')->count();
    $hilang      = Barang::where('status_barang', 'Hilang')->count();

    $grafikSTO = Barang::selectRaw('status_barang, COUNT(*) as total')
        ->groupBy('status_barang')
        ->get();

    $listSTO = StockOpname::latest()->get();

    return view('dashboard.index', compact(
        'totalUser',
        'totalBarang',
        'totalSTO',
        'sangatLayak',
        'cukupLayak',
        'layakPakai',
        'rusak',
        'hilang',
        'grafikSTO',
        'listSTO'
    ));
}
}