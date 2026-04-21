<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Divisi;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::with('divisi')->orderBy('id')->get();
        $divisi   = Divisi::orderBy('nama_divisi')->get();

        return view('karyawan.index', compact('karyawan','divisi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_karyawan'=> 'required|unique:karyawan,nama_karyawan',
            'divisi_id'     => 'required|exists:divisi,id',
        ],[
            'nama_karyawan.unique' => 'Nama karyawan sudah ada!',
            'nama_karyawan.required' => 'Nama karyawan wajib diisi!',
            'divisi_id.required' => 'Divisi wajib dipilih!',
        ]);

        // AUTO GENERATE ID KARYAWAN
        $last = Karyawan::orderBy('id','desc')->first();
        $number = $last && $last->id_karyawan 
                    ? (int) substr($last->id_karyawan, 3) + 1 
                    : 1;

        $id_karyawan = 'KRY' . str_pad($number, 3, '0', STR_PAD_LEFT);

        Karyawan::create([
            'id_karyawan'   => $id_karyawan,
            'nama_karyawan' => trim($request->nama_karyawan),
            'divisi_id'     => $request->divisi_id,
        ]);

        return back()->with('success','Data karyawan berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $request->validate([
            'nama_karyawan'=> 'required|unique:karyawan,nama_karyawan,'.$id,
            'divisi_id'     => 'required|exists:divisi,id',
        ],[
            'nama_karyawan.unique' => 'Nama karyawan sudah ada!',
            'nama_karyawan.required' => 'Nama karyawan wajib diisi!',
            'divisi_id.required' => 'Divisi wajib dipilih!',
        ]);

        $karyawan->update([
            'nama_karyawan' => trim($request->nama_karyawan),
            'divisi_id'     => $request->divisi_id,
        ]);

        return back()->with('success','Data karyawan berhasil diperbarui');
    }

    public function destroy($id)
    {
        Karyawan::findOrFail($id)->delete();
        return back()->with('success','Data karyawan berhasil dihapus');
    }
}