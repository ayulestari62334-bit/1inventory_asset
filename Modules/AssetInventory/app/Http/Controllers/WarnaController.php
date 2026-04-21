<?php

namespace Modules\AssetInventory\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\AssetInventory\app\Models\Warna;

class WarnaController extends Controller
{
    public function index()
    {
        $warna = Warna::latest()->get();
        return view('assetinventory::warna.index', compact('warna'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_warna' => 'required|unique:warnas,nama_warna',
            'hex_warna'  => 'required',
            'keterangan' => 'nullable',
        ],[
            'nama_warna.required' => 'Nama warna wajib diisi.',
            'nama_warna.unique'   => 'Nama warna sudah digunakan.',
            'hex_warna.required'  => 'Hex warna wajib dipilih.',
        ]);

        // ==============================
        // GENERATE KODE WARNA OTOMATIS
        // FORMAT: WRN-001
        // ==============================
        $lastKode = Warna::orderBy('id', 'desc')->value('kode_warna');

        if (!$lastKode) {
            $kode = 'WRN-001';
        } else {
            $angka = (int) str_replace('WRN-', '', $lastKode);
            $kode  = 'WRN-' . str_pad($angka + 1, 3, '0', STR_PAD_LEFT);
        }

        Warna::create([
            'kode_warna' => $kode,
            'nama_warna' => $request->nama_warna,
            'hex_warna'  => $request->hex_warna,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('warna.index')
            ->with('success', 'Warna berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $warna = Warna::findOrFail($id);

        $request->validate([
            'nama_warna' => 'required|unique:warnas,nama_warna,' . $warna->id,
            'hex_warna'  => 'required',
            'keterangan' => 'nullable',
        ],[
            'nama_warna.required' => 'Nama warna wajib diisi.',
            'nama_warna.unique'   => 'Nama warna sudah digunakan.',
            'hex_warna.required'  => 'Hex warna wajib dipilih.',
        ]);

        $warna->update([
            'nama_warna' => $request->nama_warna,
            'hex_warna'  => $request->hex_warna,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('warna.index')
            ->with('success', 'Warna berhasil diupdate');
    }

    public function destroy($id)
    {
        Warna::findOrFail($id)->delete();

        return redirect()->route('warna.index')
            ->with('success', 'Warna berhasil dihapus');
    }
}