@extends('layouts.app')

@section('title','Data Merek')

@section('content')

@php
    $isAdmin = auth()->user()->role === 'administrator';
@endphp

<h4 class="mb-3">Data Merek</h4>

{{-- TOAST --}}
@if(session('success'))
<div class="toast-center toast-success toast-msg">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="toast-center toast-error toast-msg">{{ session('error') }}</div>
@endif

@if ($errors->any())
<div class="toast-center toast-error toast-msg">{{ $errors->first() }}</div>
@endif

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
/* ===== FONT SAMA DENGAN MASTER DATA LAIN ===== */
body, h1, h2, h3, h4, h5, h6,
p, span, a, button, input, select, textarea, table {
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
}

/* TOAST */
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

/* TABLE & MODAL FONT */
.kode-tipis{
    font-weight:400;
    letter-spacing:.4px;
    text-align:center;
}
.modal-header{
    background:#0d6efd;
    color:#fff;
}
.modal-header .close, .modal-header .btn-close{
    color:#fff;
    opacity:.8;
}

/* BUTTON ACTION */
.btn-action{
    width:32px;
    height:32px;
    padding:0;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:8px;
}

/* TABLE STYLE */
.table-sm th,
.table-sm td{
    padding:0.25rem;
    vertical-align:middle;
    font-size:0.78rem;
}
thead th{
    font-size:0.78rem;
}
.table{
    border-collapse:collapse;
}
</style>

<div class="card shadow-sm">
    <div class="card-header bg-primary py-2 text-white">
        <strong>DATA MEREK</strong>
    </div>

    <div class="card-body">

        <div class="d-flex justify-content-between mb-2">

            @if($isAdmin)
            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bi bi-plus-circle"></i> Tambah
            </button>
            @endif

            <input type="text"
                   id="search"
                   class="form-control form-control-sm"
                   style="width:250px"
                   placeholder="Cari data...">

        </div>

        <p class="mb-2"><strong>Total Data :</strong> {{ $merek->count() }}</p>

        <table class="table table-bordered table-sm">
            <thead class="bg-primary text-white text-center">
                <tr>
                    <th width="40">No</th>
                    <th>Kode Merek</th>
                    <th>Nama Merek</th>
                    <th>Keterangan</th>
                    @if($isAdmin)
                    <th width="120">Aksi</th>
                    @endif
                </tr>
            </thead>

            <tbody id="tableBody">
            @forelse($merek as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center kode-tipis">{{ $item->kode_merek }}</td>
                    <td>{{ $item->nama_merek }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>

                    @if($isAdmin)
                    <td class="text-center">
                        <div class="d-flex justify-content-center" style="gap:8px">
                            <button class="btn btn-warning btn-sm btn-action"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEdit{{ $item->id }}">
                                <i class="bi bi-pencil-square"></i>
                            </button>

                            <form action="{{ route('merek.destroy',$item->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm btn-action">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                    @endif
                </tr>

                {{-- MODAL EDIT --}}
                @if($isAdmin)
                <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered" style="max-width:360px;">
                        <form action="{{ route('merek.update',$item->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header py-2">
                                    <h6 class="modal-title">Edit Merek</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="kode_merek" value="{{ $item->kode_merek }}">
                                    <div class="form-group">
                                        <label>Nama Merek</label>
                                        <input class="form-control form-control-sm"
                                               name="nama_merek"
                                               value="{{ $item->nama_merek }}"
                                               required>
                                    </div>
                                    <div class="form-group">
                                        <label>Keterangan</label>
                                        <textarea class="form-control form-control-sm"
                                                  name="keterangan"
                                                  rows="2">{{ $item->keterangan }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer py-2">
                                    <button type="button"
                                            class="btn btn-secondary btn-sm"
                                            data-bs-dismiss="modal">
                                        Batal
                                    </button>
                                    <button type="submit"
                                            class="btn btn-primary btn-sm">
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @endif

            @empty
                <tr>
                    <td colspan="{{ $isAdmin ? 5 : 4 }}" class="text-center text-muted">
                        DATA BELUM TERSEDIA
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

    </div>
</div>

{{-- MODAL TAMBAH --}}
@if($isAdmin)
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:360px;">
        <form action="{{ route('merek.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h6 class="modal-title">Tambah Merek</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <button class="btn btn-info btn-sm btn-block mb-3" disabled>
                        <i class="bi bi-hash"></i> Kode dibuat otomatis
                    </button>
                    <div class="form-group">
                        <label>Nama Merek</label>
                        <input type="text"
                               name="nama_merek"
                               class="form-control form-control-sm"
                               required>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan"
                                  class="form-control form-control-sm"
                                  rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer py-2">
                    <button type="button"
                            class="btn btn-secondary btn-sm"
                            data-bs-dismiss="modal">Batal</button>
                    <button type="submit"
                            class="btn btn-primary btn-sm">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif

<script>
setTimeout(()=>{ document.querySelectorAll('.toast-msg').forEach(el=>el.remove()) },3000);

document.getElementById('search').addEventListener('keyup', function(){
    let v = this.value.toLowerCase();
    document.querySelectorAll('#tableBody tr').forEach(r=>{
        r.style.display = r.innerText.toLowerCase().includes(v) ? '' : 'none';
    });
});
</script>

@endsection