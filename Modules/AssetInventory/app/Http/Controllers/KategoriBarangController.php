<?php

namespace Modules\AssetInventory\app\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AssetInventory\app\Models\KategoriBarang;

class KategoriBarangController extends Controller
{
    public function index()
    {
        $kategori = KategoriBarang::orderBy('id','desc')->get();
        return view('assetinventory::kategori.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required',
            'keterangan'    => 'required',
        ]);

        if (KategoriBarang::where('nama_kategori',$request->nama_kategori)->exists()) {
            return back()->with('error','Nama kategori sudah ada');
        }

        $last = KategoriBarang::orderBy('id','desc')->first();
        $number = $last ? (int)substr($last->kode_barang,-3)+1 : 1;
        $kode = 'KAT-'.str_pad($number,3,'0',STR_PAD_LEFT);

        KategoriBarang::create([
            'kode_barang'   => $kode,
            'nama_kategori' => $request->nama_kategori,
            'keterangan'    => $request->keterangan,
        ]);

        return back()->with('success','Kategori berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriBarang::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required',
            'keterangan'    => 'nullable',
        ]);

        if (
            KategoriBarang::where('nama_kategori',$request->nama_kategori)
                ->where('id','!=',$id)
                ->exists()
        ) {
            return back()->with('error','Nama kategori sudah digunakan');
        }

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'keterangan'    => $request->keterangan,
        ]);

        return back()->with('success','Kategori berhasil diupdate');
    }

    public function destroy($id)
    {
        KategoriBarang::findOrFail($id)->delete();
        return back()->with('success','Kategori berhasil dihapus');
    }
}
