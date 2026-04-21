@extends('layouts.app')

@section('content')
<div class="container">

<h4>Tambah Stock Opname</h4>

<form action="{{ route('stock-opname.store') }}" method="POST">
@csrf

<label>Kode STO</label>
<input type="text" name="kode_sto" class="form-control mb-2" required>

<label>Tanggal</label>
<input type="date" name="tanggal" class="form-control mb-2" required>

<label>Status</label>
<select name="status" class="form-control mb-3">
    <option value="Proses">Proses</option>
    <option value="Selesai">Selesai</option>
</select>

<button class="btn btn-primary">Simpan</button>
<a href="{{ route('stock-opname.index') }}" class="btn btn-secondary">Kembali</a>

</form>
</div>
@endsection
