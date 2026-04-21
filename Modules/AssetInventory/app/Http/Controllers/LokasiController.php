<?php

namespace Modules\AssetInventory\app\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AssetInventory\app\Models\Lokasi;

class LokasiController extends Controller
{
    public function index()
    {
        $lokasi = Lokasi::orderBy('id', 'desc')->get();
        return view('assetinventory::lokasi.index', compact('lokasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required|unique:lokasi,nama_lokasi',
            'keterangan'  => 'nullable',
        ],[
            'nama_lokasi.required' => 'Nama lokasi wajib diisi.',
            'nama_lokasi.unique'   => 'Nama lokasi sudah terdaftar!',
        ]);

        // AUTO GENERATE KODE LOKASI
        $lastKode = Lokasi::orderBy('id', 'desc')->value('kode_lokasi');

        $number = $lastKode
            ? (int) preg_replace('/\D/', '', $lastKode) + 1
            : 1;

        $kodeLokasi = 'LKS-' . str_pad($number, 3, '0', STR_PAD_LEFT);

        Lokasi::create([
            'kode_lokasi' => $kodeLokasi,
            'nama_lokasi' => $request->nama_lokasi,
            'keterangan'  => $request->keterangan,
        ]);

        return redirect()->route('lokasi.index')
            ->with('success', 'Lokasi berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $lokasi = Lokasi::findOrFail($id);

        $request->validate([
            'nama_lokasi' => 'required|unique:lokasi,nama_lokasi,' . $lokasi->id,
            'keterangan'  => 'nullable',
        ],[
            'nama_lokasi.required' => 'Nama lokasi wajib diisi.',
            'nama_lokasi.unique'   => 'Nama lokasi sudah digunakan!',
        ]);

        $lokasi->update([
            'nama_lokasi' => $request->nama_lokasi,
            'keterangan'  => $request->keterangan,
        ]);

        return redirect()->route('lokasi.index')
            ->with('success', 'Lokasi berhasil diupdate');
    }

    public function destroy($id)
    {
        Lokasi::findOrFail($id)->delete();

        return redirect()->route('lokasi.index')
            ->with('success', 'Lokasi berhasil dihapus');
    }
}