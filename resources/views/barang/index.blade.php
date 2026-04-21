@extends('layouts.app')

@section('content')

@php
$isAdmin = strtolower(auth()->user()->role ?? '') === 'administrator';
@endphp

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
.toast-center{
position: fixed;
top: 50%;
left: 50%;
transform: translate(-50%, -50%);
padding: 14px 24px;
border-radius: 10px;
color: #fff;
font-size: 14px;
box-shadow: 0 10px 25px rgba(0,0,0,.3);
z-index: 99999;
opacity: 1;
transition: opacity .5s ease;
}

.toast-berhasil{ background:#28a745; }
.toast-gagal{ background:#dc3545; }

.btn-action{
width:32px;
height:32px;
padding:0;
display:flex;
align-items:center;
justify-content:center;
border-radius:8px;
border:1px solid rgba(0,0,0,.15);
font-size:14px;
}

.btn-action i{
pointer-events:none;
}

.table-sm th,.table-sm td{
padding:0.35rem;
vertical-align:middle;
font-size:0.875rem;
}

.table-hover tbody tr:hover{
background-color: rgba(0,0,0,.03);
}

/* fallback jika bootstrap gap tidak aktif */
.d-flex.gap-1 > *{
margin-right:4px;
}
.d-flex.gap-1 > *:last-child{
margin-right:0;
}
</style>
@endpush

<h4 class="mb-3 fw-bold">Master Data Barang</h4>

@if(session('success') || session('error') || $errors->any())

<div class="toast-center 
{{ session('success') ? 'toast-berhasil' : 'toast-gagal' }}" 
id="toast">

@if(session('success'))
{{ session('success') }}
@elseif(session('error'))
{{ session('error') }}
@elseif($errors->any())
{{ $errors->first() }}
@endif

</div>

@endif

<div class="card shadow-sm">

<div class="card-header bg-primary py-2 text-white">
<strong>DATA BARANG</strong>
</div>

<div class="card-body pt-3">

<div class="d-flex justify-content-between mb-2 align-items-center">

@if($isAdmin)

<div class="d-flex align-items-center">

<button type="button"
class="btn btn-success btn-sm mr-2"
data-bs-toggle="modal"
data-bs-target="#modalTambah">
<i class="bi bi-plus-circle"></i> Tambah
</button>

<form action="{{ route('barang.destroyAll') }}"
method="POST"
class="d-inline"
onsubmit="return confirm('Yakin ingin menghapus SEMUA data barang?')">

@csrf
@method('DELETE')

<button type="submit"
class="btn btn-danger btn-sm">
Hapus Semua
</button>

</form>

</div>

@endif

<input type="text"
id="search"
class="form-control form-control-sm w-25"
placeholder="Cari data...">

</div>

<p class="mb-2">
<strong>Total Data :</strong> {{ $barang->count() }}
</p>

<div class="table-responsive">

<table class="table table-bordered table-sm table-hover text-center align-middle">

<thead class="bg-primary text-white">

<tr>
<th>No</th>
<th>No Asset</th>
<th>Kategori</th>
<th>Jenis</th>
<th>Karyawan</th>
<th>Divisi</th>
<th>Lokasi</th>
<th>Status</th>
<th width="150">Aksi</th>
</tr>

</thead>

<tbody id="tableBody">

@forelse($barang as $b)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $b->no_asset }}</td>

<td>{{ $b->kategori->nama_kategori ?? '-' }}</td>

<td>{{ $b->jenis->nama_jenis ?? '-' }}</td>

<td>{{ $b->karyawan->nama_karyawan ?? '-' }}</td>

<td>{{ $b->karyawan->divisi->nama_divisi ?? '-' }}</td>

<td>{{ $b->lokasi->nama_lokasi ?? '-' }}</td>

<td>
<span class="badge bg-{{ $b->status_barang == 'Aktif' ? 'success' : 'secondary' }}">
{{ $b->status_barang }}
</span>
</td>

<td>

<div class="d-flex justify-content-center gap-1">

<a href="{{ route('barang.show',$b->id) }}"
class="btn btn-info btn-sm btn-action"
title="Detail">
<i class="bi bi-eye"></i>
</a>

@if($isAdmin)

<button type="button"
class="btn btn-warning btn-sm btn-action"
data-bs-toggle="modal"
data-bs-target="#modalEdit{{ $b->id }}"
title="Edit">
<i class="bi bi-pencil-square"></i>
</button>

@endif

<a href="{{ route('barang.printQr',$b->id) }}"
target="_blank"
class="btn btn-dark btn-sm btn-action"
title="Print QR">
<i class="bi bi-qr-code"></i>
</a>

@if($isAdmin)

<form action="{{ route('barang.destroy',$b->id) }}"
method="POST"
class="d-inline"
onsubmit="return confirm('Hapus data ini?')">

@csrf
@method('DELETE')

<button type="submit"
class="btn btn-danger btn-sm btn-action"
title="Hapus">
<i class="bi bi-trash3"></i>
</button>

</form>

@endif

</div>

</td>

</tr>

@empty

<tr>
<td colspan="9" class="text-muted">
DATA BELUM TERSEDIA
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

@foreach($barang as $b)

@if($isAdmin)

<div class="modal fade" id="modalEdit{{ $b->id }}" tabindex="-1">

<div class="modal-dialog modal-lg modal-dialog-centered">

<div class="modal-content shadow">

<form action="{{ route('barang.update',$b->id) }}" 
method="POST"
enctype="multipart/form-data">

@csrf
@method('PUT')

<div class="modal-header bg-warning text-white py-2">

<h6 class="mb-0">Edit Barang</h6>

<!-- Tombol close versi Bootstrap 5 -->
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

</div>

<div class="modal-body">

<div class="row">

<div class="col-md-4 mb-3">
<label>Kategori</label>

<select name="kategori_id" class="form-control form-control-sm" required>
@foreach($kategori as $k)
<option value="{{ $k->id }}" {{ $b->kategori_id==$k->id?'selected':'' }}>
{{ $k->nama_kategori }}
</option>
@endforeach
</select>
</div>

<div class="col-md-4 mb-3">
<label>Jenis</label>
<select name="jenis_id" class="form-control form-control-sm" required>
@foreach($jenis as $j)
<option value="{{ $j->id }}" {{ $b->jenis_id==$j->id?'selected':'' }}>
{{ $j->nama_jenis }}
</option>
@endforeach
</select>
</div>

<div class="col-md-4 mb-3">
<label>Merek</label>
<select name="merek_id" class="form-control form-control-sm" required>
@foreach($merek as $m)
<option value="{{ $m->id }}" {{ $b->merek_id==$m->id?'selected':'' }}>
{{ $m->nama_merek }}
</option>
@endforeach
</select>
</div>

<div class="col-md-4 mb-3">
<label>Warna</label>
<select name="warna_id" class="form-control form-control-sm" required>
@foreach($warna as $w)
<option value="{{ $w->id }}" {{ $b->warna_id==$w->id?'selected':'' }}>
{{ $w->nama_warna }}
</option>
@endforeach
</select>
</div>

<div class="col-md-4 mb-3">
<label>Lokasi</label>
<select name="lokasi_id" class="form-control form-control-sm" required>
@foreach($lokasi as $l)
<option value="{{ $l->id }}" {{ $b->lokasi_id==$l->id?'selected':'' }}>
{{ $l->nama_lokasi }}
</option>
@endforeach
</select>
</div>

<div class="col-md-4 mb-3">
<label>Karyawan</label>
<select name="karyawan_id" class="form-control form-control-sm" required>
@foreach($karyawan as $k)
<option value="{{ $k->id }}" {{ $b->karyawan_id==$k->id?'selected':'' }}>
{{ $k->nama_karyawan }}
</option>
@endforeach
</select>
</div>

<div class="col-md-6 mb-3">
<label>Serial Number</label>
<input class="form-control form-control-sm"
name="serial_number"
value="{{ $b->serial_number }}">
</div>

<div class="col-md-6 mb-3">
<label>Jenis Lisensi</label>
<input class="form-control form-control-sm"
name="jenis_licence"
value="{{ $b->jenis_licence }}">
</div>

<div class="col-md-6 mb-3">
<label>Kode Lisensi</label>
<input class="form-control form-control-sm"
name="kode_licence"
value="{{ $b->kode_licence }}">
</div>

<div class="col-md-6 mb-3">
<label>Tanggal Masuk</label>
<input type="date"
class="form-control form-control-sm"
name="tanggal_masuk"
value="{{ $b->tanggal_masuk ?? date('Y-m-d') }}">
</div>

<div class="col-md-12 mb-3">
<label>Foto</label>
<input type="file"
class="form-control form-control-sm preview-input"
name="foto">
<img src="#"
class="img-preview mt-2"
style="display:none; max-height:150px; border-radius:8px;">
</div>

</div>
</div>

<div class="modal-footer py-2">
<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
<button class="btn btn-warning btn-sm">Simpan</button>
</div>

</form>

</div>
</div>
</div>

@endif
@endforeach

@include('barang.partials.modal-tambah')

<script>
document.addEventListener("DOMContentLoaded",function(){

/* toast auto hide */
setTimeout(function(){
let toast=document.getElementById('toast');
if(toast){
toast.style.opacity='0';
setTimeout(()=>toast.remove(),500);
}
},3000);

/* preview gambar */
document.querySelectorAll('.preview-input').forEach(input=>{
input.addEventListener('change',function(){
const preview=this.nextElementSibling;
const file=this.files[0];
if(file){
const reader=new FileReader();
reader.onload=e=>{
preview.src=e.target.result;
preview.style.display='block';
}
reader.readAsDataURL(file);
}
});
});

/* search table */
let search=document.getElementById('search');
if(search){
search.addEventListener('keyup',function(){
let v=this.value.toLowerCase();
document.querySelectorAll('#tableBody tr').forEach(r=>{
r.style.display = r.innerText.toLowerCase().includes(v) ? '' : 'none';
});
});
}

});
</script>

@endsection