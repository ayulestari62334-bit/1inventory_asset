<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockOpnameDetail;
use App\Models\StockOpname;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Laravel\Facades\Image;

class StockOpnameDetailController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'stock_opname_id' => 'required|exists:stock_opnames,id',
            'status' => 'required|in:layak,tidak_layak',
            'stok_fisik' => 'nullable|integer',
            'foto_barang' => 'nullable|image|max:5120'
        ]);

        // Ambil detail barang
        $detail = StockOpnameDetail::where('barang_id', $request->barang_id)
            ->where('stock_opname_id', $request->stock_opname_id)
            ->firstOrFail();

        // Upload foto baru jika ada
        $fotoPath = $detail->foto_barang;
        if ($request->hasFile('foto_barang')) {
            $folderPath = public_path('stock_opname');
            if (!file_exists($folderPath)) mkdir($folderPath, 0755, true);

            $foto = $request->file('foto_barang');
            $fotoName = time() . '_' . uniqid() . '.jpg';

            $img = Image::read($foto);
            $img->scale(width: 800);
            $img->save($folderPath . '/' . $fotoName, quality: 70);

            $fotoPath = 'stock_opname/' . $fotoName;
        }

        // Update detail barang
        $detail->update([
            'status' => $request->status,
            'stok_fisik' => $request->stok_fisik ?? $detail->stok_sistem,
            'foto_barang' => $fotoPath,
            'scanned_by' => Auth::id(),
            'scanned_at' => now()
        ]);

        // Cek apakah semua barang sudah di-scan
        $belumScan = StockOpnameDetail::where('stock_opname_id', $request->stock_opname_id)
            ->where('status', 'pending') // ✅ FIX DI SINI
            ->count();

        if ($belumScan === 0) {
            $stockOpname = StockOpname::find($request->stock_opname_id);
            $stockOpname->status = 'selesai';
            $stockOpname->save();
        }

        return back()->with('success', 'Barang berhasil di-scan dan diupdate');
    }
}