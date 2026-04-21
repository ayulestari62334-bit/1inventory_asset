<?php

namespace Modules\AssetInventory\app\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AssetInventory\app\Models\JenisBarang;

class JenisBarangController extends Controller
{
    public function index()
    {
        $jenis = JenisBarang::orderBy('id', 'desc')->get();

        return view('assetinventory::jenis.index', compact('jenis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:100',
            'keterangan' => 'nullable|string',
        ]);

        // CEK DUPLIKAT NAMA
        if (
            JenisBarang::whereRaw('LOWER(nama_jenis) = ?', [strtolower($request->nama_jenis)])
                ->exists()
        ) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Nama jenis sudah ada');
        }

        // AUTO GENERATE KODE JENIS
        $lastKode = JenisBarang::orderBy('id', 'desc')->value('kode_jenis');

        $number = $lastKode
            ? (int) preg_replace('/\D/', '', $lastKode) + 1
            : 1;

        $kodeJenis = 'JNS-' . str_pad($number, 3, '0', STR_PAD_LEFT);

        JenisBarang::create([
            'kode_jenis' => $kodeJenis,
            'nama_jenis' => $request->nama_jenis,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()
            ->with('success', 'Jenis berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:100',
            'keterangan' => 'nullable|string',
        ]);

        $jenis = JenisBarang::findOrFail($id);

        // CEK DUPLIKAT SAAT UPDATE
        if (
            JenisBarang::whereRaw('LOWER(nama_jenis) = ?', [strtolower($request->nama_jenis)])
                ->where('id', '!=', $id)
                ->exists()
        ) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Nama jenis sudah ada');
        }

        $jenis->update([
            'nama_jenis' => $request->nama_jenis,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()
            ->with('success', 'Jenis berhasil diupdate');
    }

    public function destroy($id)
    {
        JenisBarang::findOrFail($id)->delete();

        return redirect()->back()
            ->with('success', 'Jenis berhasil dihapus');
    }
}
