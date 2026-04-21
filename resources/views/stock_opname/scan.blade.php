@extends('layouts.app')

@section('title', 'Scan Stock Opname')

@section('content')
<h4 class="mb-3">Scan Stock Opname: {{ $stockOpname->kode_sto }}</h4>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No Asset</th>
            <th>Nama Barang</th>
            <th>Stok Sistem</th>
            <th>Stok Fisik</th>
            <th>Status</th>
            <th>Foto</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($stockOpname->details as $detail)
        <tr>
            <td>{{ $detail->barang->no_asset }}</td>
            <td>{{ $detail->barang->kategori->nama_kategori ?? '-' }} /
                {{ $detail->barang->jenis->nama_jenis ?? '-' }} /
                {{ $detail->barang->merek->nama_merek ?? '-' }}</td>
            <td>{{ $detail->stok_sistem }}</td>
            <td>{{ $detail->stok_fisik ?? '-' }}</td>
            <td>
                @if($detail->status)
                    {{ $detail->status }}
                @else
                    <span class="text-warning">Belum di-scan</span>
                @endif
            </td>
            <td>
                @if($detail->foto_barang)
                    <img src="{{ asset('stock_opname/'.$detail->foto_barang) }}" width="50">
                @else
                    -
                @endif
            </td>
            <td>
                @if(!$detail->status)
                <form action="{{ route('stock-opname.updateDetail') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="detail_id" value="{{ $detail->id }}">
                    <select name="status" class="form-control mb-1" required>
                        <option value="">Pilih Status</option>
                        <option value="layak">Layak</option>
                        <option value="tidak_layak">Tidak Layak</option>
                    </select>
                    <input type="number" name="stok_fisik" class="form-control mb-1" placeholder="Stok Fisik">
                    <input type="file" name="foto_barang" class="form-control mb-1">
                    <button type="submit" class="btn btn-success btn-sm">Scan</button>
                </form>
                @else
                    <span class="text-success">Sudah di-scan</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@if($stockOpname->details->whereNull('status')->count() == 0 && $stockOpname->status == 'proses')
<form action="{{ route('stock-opname.close', $stockOpname->id) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-primary">Tutup Stock Opname</button>
</form>
@endif

@endsection