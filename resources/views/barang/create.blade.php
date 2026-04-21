@extends('layouts.app')

@section('content')
<div class="container">

<h4>Tambah Data Barang</h4>

<form action="/barang" method="POST" enctype="multipart/form-data">
@csrf

<label>Kategori</label>
<select name="kategori_id" class="form-control mb-2" required>
@foreach($kategori as $k)
<option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
@endforeach
</select>

<label>Jenis</label>
<select name="jenis_id" class="form-control mb-2" required>
@foreach($jenis as $j)
<option value="{{ $j->id }}">{{ $j->nama_jenis }}</option>
@endforeach
</select>

{{-- ✅ FIX: merk ➜ merek --}}
<label>Merek</label>
<select name="merek_id" class="form-control mb-2" required>
@foreach($merek as $m)
<option value="{{ $m->id }}">{{ $m->nama_merek }}</option>
@endforeach
</select>

<label>Warna</label>
<select name="warna_id" class="form-control mb-2" required>
@foreach($warna as $w)
<option value="{{ $w->id }}">{{ $w->nama_warna }}</option>
@endforeach
</select>

<label>Lokasi</label>
<select name="lokasi_id" class="form-control mb-2" required>
@foreach($lokasi as $l)
<option value="{{ $l->id }}">{{ $l->nama_lokasi }}</option>
@endforeach
</select>

<label>Karyawan</label>
<select name="karyawan_id" class="form-control mb-2" required>
@foreach($karyawan as $k)
<option value="{{ $k->id }}">
{{ $k->nama_karyawan }} - {{ $k->divisi->nama_divisi }}
</option>
@endforeach
</select>

<label>Foto</label>
<input type="file" name="foto" class="form-control mb-2">

<label>Serial Number</label>
<input type="text" name="serial_number" class="form-control mb-2" required>

<label>Jenis Licence</label>
<input type="text" name="jenis_licence" class="form-control mb-2" required>

<label>Kode Licence</label>
<input type="text" name="kode_licence" class="form-control mb-2" required>

<label>Tanggal Masuk</label>
<input type="date" name="tanggal_masuk" class="form-control mb-3" required>

<button class="btn btn-success">
Simpan
</button>

</form>
</div>
@endsection
