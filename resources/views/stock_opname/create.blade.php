@extends('layouts.app')

@section('content')
<div class="container">

<h4>Tambah Stock Opname</h4>

<form action="{{ route('stock-opname.store') }}" method="POST">
@csrf

<div class="mb-3">
    <label>Kode STO</label>
    <input type="text" name="kode_sto" class="form-control" required>
</div>

<div class="mb-3">
    <label>Tanggal</label>
    <input type="date" name="tanggal" class="form-control" required>
</div>

<button class="btn btn-success">Simpan</button>

</form>

</div>
@endsection

