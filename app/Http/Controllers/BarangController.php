<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Laravel\Facades\Image;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Modules\AssetInventory\app\Models\KategoriBarang;
use Modules\AssetInventory\app\Models\JenisBarang;
use Modules\AssetInventory\app\Models\Merek;
use Modules\AssetInventory\app\Models\Warna;
use Modules\AssetInventory\app\Models\Lokasi;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::with([
            'kategori',
            'jenis',
            'merek',
            'warna',
            'lokasi',
            'karyawan.divisi'
        ])->latest()->get();

        return view('barang.index', [
            'barang'   => $barang,
            'kategori' => KategoriBarang::all(),
            'jenis'    => JenisBarang::all(),
            'merek'    => Merek::all(),
            'warna'    => Warna::all(),
            'lokasi'   => Lokasi::all(),
            'karyawan' => Karyawan::with('divisi')->get(),
        ]);
    }

    public function show($id)
    {
        $barang = Barang::with([
            'kategori',
            'jenis',
            'merek',
            'warna',
            'lokasi',
            'karyawan.divisi'
        ])->findOrFail($id);

        return view('barang.detail', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id'   => 'required|exists:kategori_barang,id',
            'jenis_id'      => 'required|exists:jenis_barang,id',
            'merek_id'      => 'required|exists:mereks,id',
            'warna_id'      => 'required|exists:warnas,id',
            'lokasi_id'     => 'required|exists:lokasi,id',
            'karyawan_id'   => 'required|exists:karyawan,id',
            'serial_number' => 'nullable|unique:barang,serial_number',
            'tanggal_masuk' => 'required|date',
            'foto'          => 'nullable|image|max:5120'
        ]);

        $kategori = KategoriBarang::findOrFail($request->kategori_id);
        $jenis    = JenisBarang::findOrFail($request->jenis_id);
        $merek    = Merek::findOrFail($request->merek_id);
        $warna    = Warna::findOrFail($request->warna_id);

        $kodeKategori = str_pad((string)$kategori->kode_barang, 3, '0', STR_PAD_LEFT);
        $kodeJenis    = str_pad((string)$jenis->kode_jenis, 3, '0', STR_PAD_LEFT);
        $kodeMerek    = str_pad((string)$merek->kode_merek, 3, '0', STR_PAD_LEFT);
        $kodeWarna    = str_pad((string)$warna->kode_warna, 3, '0', STR_PAD_LEFT);

        $prefix = $kodeKategori.'-'.$kodeJenis.'-'.$kodeMerek.'-'.$kodeWarna;

        $lastBarang = Barang::where('no_asset','like',$prefix.'-%')
            ->orderBy('no_asset','desc')
            ->first();

        $newNumber = $lastBarang
            ? ((int) end(explode('-', $lastBarang->no_asset))) + 1
            : 1;

        $urutan  = str_pad($newNumber,3,'0',STR_PAD_LEFT);
        $noAsset = $prefix.'-'.$urutan;

        $fotoName = null;

        if ($request->hasFile('foto')) {
            $folderPath = public_path('barang');
            if (!file_exists($folderPath)) {
                mkdir($folderPath,0755,true);
            }

            $foto = $request->file('foto');
            $fotoName = time().'_'.uniqid().'.jpg';

            $img = Image::read($foto);
            $img->scale(width:800);
            $img->save($folderPath.'/'.$fotoName,quality:70);
        }

        Barang::create([
            'no_asset'       => $noAsset,
            'kategori_id'    => $request->kategori_id,
            'jenis_id'       => $request->jenis_id,
            'merek_id'       => $request->merek_id,
            'warna_id'       => $request->warna_id,
            'lokasi_id'      => $request->lokasi_id,
            'karyawan_id'    => $request->karyawan_id,
            'foto'           => $fotoName,
            'serial_number'  => $request->serial_number ?: '-',
            'jenis_licence'  => $request->jenis_licence ?: '-',
            'kode_licence'   => $request->kode_licence ?: '-',
            'tanggal_masuk'  => $request->tanggal_masuk,
            'status_barang'  => 'Belum STO'
        ]);

        return back()->with('success','Barang berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_id'   => 'required|exists:kategori_barang,id',
            'jenis_id'      => 'required|exists:jenis_barang,id',
            'merek_id'      => 'required|exists:mereks,id',
            'warna_id'      => 'required|exists:warnas,id',
            'lokasi_id'     => 'required|exists:lokasi,id',
            'karyawan_id'   => 'nullable|exists:karyawan,id',
            'serial_number' => 'nullable|unique:barang,serial_number,'.$id,
            'tanggal_masuk' => 'nullable|date',
            'foto'          => 'nullable|image|max:5120'
        ]);

        $barang = Barang::findOrFail($id);

        $fotoName = $barang->foto;

        if ($request->hasFile('foto')) {
            $folderPath = public_path('barang');
            if (!file_exists($folderPath)) {
                mkdir($folderPath,0755,true);
            }

            $foto = $request->file('foto');
            $fotoName = time().'_'.uniqid().'.jpg';

            $img = Image::read($foto);
            $img->scale(width:800);
            $img->save($folderPath.'/'.$fotoName,quality:70);
        }

        $tanggalMasuk = $request->tanggal_masuk ?: now();

        $barang->update([
            'kategori_id'    => $request->kategori_id,
            'jenis_id'       => $request->jenis_id,
            'merek_id'       => $request->merek_id,
            'warna_id'       => $request->warna_id,
            'lokasi_id'      => $request->lokasi_id,
            'karyawan_id'    => $request->karyawan_id,
            'serial_number'  => $request->serial_number ?: '-',
            'jenis_licence'  => $request->jenis_licence ?: '-',
            'kode_licence'   => $request->kode_licence ?: '-',
            'tanggal_masuk'  => $tanggalMasuk,
            'foto'           => $fotoName
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diupdate.');
    }

    public function printQr($id)
    {
        $barang = Barang::with([
            'kategori',
            'jenis',
            'merek',
            'warna',
            'lokasi',
            'karyawan.divisi'
        ])->findOrFail($id);

        $isiQr = "
PT DESIGN JAYA INDONESIA (KIOS BANK)
Kode Asset : {$barang->no_asset}
Kategori   : ".($barang->kategori->nama_kategori ?? '-')."
Jenis      : ".($barang->jenis->nama_jenis ?? '-')."
Merek      : ".($barang->merek->nama_merek ?? '-')."
Warna      : ".($barang->warna->nama_warna ?? '-')."
Divisi     : ".($barang->karyawan->divisi->nama_divisi ?? '-')."
Lokasi     : ".($barang->lokasi->nama_lokasi ?? '-')."
Status     : {$barang->status_barang}
";

        $qr = QrCode::size(300)->generate($isiQr);

        return view('barang.qr-single', compact('qr','barang'));
    }

    // ✅ TAMBAHAN FIX ERROR
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        $barang->delete(); // atau pakai isdeleted kalau kamu pakai soft delete manual

        return redirect()->route('barang.index')
            ->with('success', 'Data barang berhasil dihapus');
    }
}