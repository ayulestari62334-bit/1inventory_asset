<?php

namespace App\Http\Controllers;

use App\Models\StockOpname;
use App\Models\StockOpnameDetail;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Laravel\Facades\Image;

class StockOpnameController extends Controller
{
    public function index()
    {
        $stockOpnames = StockOpname::latest()->get();
        return view('stock_opname.index', compact('stockOpnames'));
    }

    public function create()
    {
        $aktif = StockOpname::where('status', 'proses')->first();
        if ($aktif) {
            return redirect()->route('stock-opname.index')
                ->with('error', 'Masih ada stock opname yang belum selesai!');
        }

        return view('stock_opname.create');
    }

    public function store(Request $request)
    {
        $cek = StockOpname::where('status', 'proses')->first();
        if ($cek) {
            return back()->with('error', 'Masih ada stock opname yang belum selesai!');
        }

        $request->validate(['tanggal' => 'required|date']);

        $kode = StockOpname::generateKode();

        // Buat stock opname
        $sto = StockOpname::create([
            'kode_sto'   => $kode,
            'tanggal'    => $request->tanggal,
            'status'     => 'proses',
            'created_by' => Auth::id()
        ]);

        // Semua barang otomatis masuk detail
        $barangs = Barang::all();
        foreach ($barangs as $barang) {
            StockOpnameDetail::create([
                'stock_opname_id' => $sto->id,
                'barang_id'       => $barang->id,
                'stok_sistem'     => 1,
                'stok_fisik'      => null,
                'status'          => 'pending',
                'scanned_by'      => null,
                'scanned_at'      => null,
                'foto_barang'     => null
            ]);
        }

        return redirect()->route('stock-opname.index')
            ->with('success', 'Stock opname dimulai');
    }

    public function show($id)
    {
        $stockOpname = StockOpname::with('details.barang')->findOrFail($id);
        return view('stock_opname.show', compact('stockOpname'));
    }

    public function destroy($id)
    {
        $stockOpname = StockOpname::findOrFail($id);
        StockOpnameDetail::where('stock_opname_id', $id)->delete();
        $stockOpname->delete();

        return back()->with('success', 'Stock opname dihapus');
    }

    public function close($id)
    {
        $stockOpname = StockOpname::with('details')->findOrFail($id);

        $belumScan = $stockOpname->details()->where('status', 'pending')->count();
        if ($belumScan > 0) {
            return back()->with('error', 'Masih ada barang yang belum di-scan!');
        }

        $stockOpname->status = 'selesai';
        $stockOpname->save();

        return back()->with('success', 'Stock opname selesai!');
    }

    // Scan QR / update status barang
    public function scan(Request $request, $detail_id)
    {
        $detail = StockOpnameDetail::findOrFail($detail_id);

        $request->validate([
            'status'      => 'required|in:layak,tidak_layak',
            'stok_fisik'  => 'nullable|integer',
            'foto_barang' => 'nullable|image|max:5120'
        ]);

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

        $detail->update([
            'status'       => $request->status, // ✅ FIX DI SINI
            'stok_fisik'   => $request->stok_fisik,
            'foto_barang'  => $fotoPath,
            'scanned_by'   => Auth::id(),
            'scanned_at'   => now()
        ]);

        return back()->with('success', 'Barang berhasil di-scan');
    }
}