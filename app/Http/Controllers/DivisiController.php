<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use Illuminate\Http\Request;

class DivisiController extends Controller
{
    public function index()
    {
        $divisi = Divisi::orderBy('nama_divisi')->get();
        return view('divisi.index', compact('divisi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_divisi' => 'required|unique:divisi,nama_divisi'
        ], [
            'nama_divisi.required' => 'Nama divisi wajib diisi!',
            'nama_divisi.unique'   => 'Nama divisi sudah ada, silahkan ganti nama!'
        ]);

        Divisi::create([
            'nama_divisi' => $request->nama_divisi
        ]);

        return back()->with('success', 'Divisi berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_divisi' => 'required|unique:divisi,nama_divisi,' . $id
        ], [
            'nama_divisi.required' => 'Nama divisi wajib diisi!',
            'nama_divisi.unique'   => 'Nama divisi sudah ada, silahkan ganti nama!'
        ]);

        Divisi::findOrFail($id)->update([
            'nama_divisi' => $request->nama_divisi
        ]);

        return back()->with('success', 'Divisi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $divisi = Divisi::findOrFail($id);

        if ($divisi->karyawan()->exists()) {
            return back()->with('error', 'Divisi masih digunakan karyawan!');
        }

        $divisi->delete();

        return back()->with('success', 'Divisi berhasil dihapus');
    }
}
