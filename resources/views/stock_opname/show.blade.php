@extends('layouts.app')

@section('title','Detail Stock Opname')

@section('content')

<h4 class="mb-3">Detail Stock Opname - {{ $stockOpname->kode_sto }}</h4>

@if(session('success'))
<div class="toast-center toast-success" id="toast">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="toast-center toast-error" id="toast">{{ session('error') }}</div>
@endif

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
.toast-center{
    position:fixed;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    padding:14px 22px;
    border-radius:10px;
    color:#fff;
    z-index:9999;
    box-shadow:0 10px 25px rgba(0,0,0,.3);
}
.toast-success{background:#28a745}
.toast-error{background:#dc3545}

.btn-action{
    width:32px;
    height:32px;
    padding:0;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:8px;
}
</style>

<div class="card shadow-sm">
    <div class="card-header bg-primary py-2 text-white">
        <strong>BARANG STOCK OPNAME</strong>
    </div>

    <div class="card-body">

        <input type="text"
               id="search"
               class="form-control form-control-sm mb-2 w-25"
               placeholder="Cari barang...">

        <table class="table table-bordered table-sm">
            <thead class="bg-primary text-white text-center">
                <tr>
                    <th width="40">No</th>
                    <th>Nama Barang</th>
                    <th>Stok Sistem</th>
                    <th>Status</th>
                    <th>Foto</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @forelse($stockOpname->details as $detail)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>

                    {{-- FIX: biar tidak error kalau barang null --}}
                    <td>{{ optional($detail->barang)->nama_barang ?? '-' }}</td>

                    <td class="text-center">{{ $detail->stok_sistem ?? '-' }}</td>

                    {{-- FIX: upgrade status jadi badge --}}
                    <td class="text-center">
                        @if($detail->status == 'layak')
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle"></i> Layak
                            </span>
                        @elseif($detail->status == 'tidak_layak')
                            <span class="badge bg-danger">
                                <i class="bi bi-x-circle"></i> Tidak Layak
                            </span>
                        @else
                            <span class="badge bg-secondary">
                                <i class="bi bi-clock"></i> Belum dicek
                            </span>
                        @endif
                    </td>

                    <td class="text-center">
                        @if($detail->foto_barang)
                            <img src="{{ asset('storage/'.$detail->foto_barang) }}" width="50" alt="Foto Barang">
                        @endif
                    </td>

                    <td class="text-center">
                        <form action="{{ route('stock-opname.updateDetail') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- FIX: fallback kalau barang_id null --}}
                            <input type="hidden" name="barang_id" value="{{ $detail->barang_id ?? optional($detail->barang)->id }}">
                            <input type="hidden" name="stock_opname_id" value="{{ $stockOpname->id }}">

                            {{-- FIX: biar selected sesuai data --}}
                            <select name="status" class="form-control mb-1" required>
                                <option value="">--Pilih Status--</option>
                                <option value="layak" {{ $detail->status == 'layak' ? 'selected' : '' }}>Layak</option>
                                <option value="tidak_layak" {{ $detail->status == 'tidak_layak' ? 'selected' : '' }}>Tidak Layak</option>
                            </select>

                            <input type="file" name="foto_barang" class="form-control mb-1">

                            <button type="submit" class="btn btn-primary btn-sm btn-action" title="Update Barang">
                                <i class="bi bi-save"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Belum ada barang</td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

<script>
setTimeout(() => document.getElementById('toast')?.remove(), 3000);

document.getElementById('search').addEventListener('keyup', function(){
    let v = this.value.toLowerCase();
    document.querySelectorAll('#tableBody tr').forEach(r => {
        r.style.display = r.innerText.toLowerCase().includes(v) ? '' : 'none';
    });
});
</script>

@endsection