@extends('layouts.app')

@section('title','Data Kategori Barang')

@section('content')

@php
    $isAdmin = strtolower(auth()->user()->role ?? '') === 'administrator';
@endphp

<h4 class="mb-3">Data Kategori Barang</h4>

{{-- TOAST --}}
@if(session('success'))
<div class="toast-center toast-success" id="toast">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="toast-center toast-error" id="toast">{{ session('error') }}</div>
@endif

@if ($errors->any())
<div class="toast-center toast-error" id="toast">{{ $errors->first() }}</div>
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

.kode-tipis{
    font-weight:400;
    letter-spacing:.4px;
}

.modal-header{
    background:#0d6efd;
    color:#fff;
}

.modal-header .close{
    color:#fff;
    opacity:.8;
}

.btn-action{
    width:32px;
    height:32px;
    padding:0;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:8px;
}

/* =========================
   MODAL KOTAK PROPORSIONAL
========================= */
.modal-dialog.modal-dialog-centered {
    max-width: 360px;   /* lebar kotak */
    width: 100%;
}

.modal-content {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    border-radius: 12px; /* sudut kotak */
}

.modal-body {
    overflow-y: auto;   /* scroll jika konten panjang */
}
</style>

<div class="card shadow-sm">

    <div class="card-header bg-primary py-2 text-white">
        <strong>DATA KATEGORI BARANG</strong>
    </div>

    <div class="card-body">

        {{-- HEADER ACTION --}}
        <div class="d-flex justify-content-between mb-2">

            @if($isAdmin)
            <button class="btn btn-success btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#modalTambah">
                <i class="bi bi-plus-circle"></i> Tambah
            </button>
            @endif

            <input type="text"
                   id="search"
                   class="form-control form-control-sm"
                   style="width:250px"
                   placeholder="Cari data...">

        </div>

        {{-- TOTAL DATA --}}
        <p class="mb-2">
            <strong>Total Data :</strong> {{ $kategori->count() }}
        </p>

        <table class="table table-bordered table-sm">
            <thead class="bg-primary text-white text-center">
                <tr>
                    <th width="40">No</th>
                    <th>Kode Kategori</th>
                    <th>Nama</th>
                    <th>Keterangan</th>
                    @if($isAdmin)
                    <th width="120">Aksi</th>
                    @endif
                </tr>
            </thead>

            <tbody id="tableBody">

            @forelse($kategori as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center kode-tipis">{{ $item->kode_barang }}</td>
                    <td>{{ $item->nama_kategori }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>

                    @if($isAdmin)
                    <td class="text-center">
                        <div class="d-flex justify-content-center" style="gap:8px">

                            <button class="btn btn-warning btn-sm btn-action"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEdit{{ $item->id }}">
                                <i class="bi bi-pencil-square"></i>
                            </button>

                            <form action="{{ url('kategori-barang/'.$item->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm btn-action">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>

                        </div>
                    </td>
                    @endif
                </tr>

                {{-- MODAL EDIT --}}
                @if($isAdmin)
                <div class="modal fade" id="modalEdit{{ $item->id }}">
                    <div class="modal-dialog modal-dialog-centered">

                        <form action="{{ url('kategori-barang/'.$item->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="modal-content">

                                <div class="modal-header py-2">
                                    <h6 class="modal-title">Edit Kategori Barang</h6>
                                    <button type="button"
                                            class="btn-close"
                                            data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>

                                <div class="modal-body">

                                    <div class="form-group">
                                        <label>Nama Kategori</label>
                                        <input class="form-control form-control-sm"
                                               name="nama_kategori"
                                               value="{{ $item->nama_kategori }}"
                                               required>
                                    </div>

                                    <div class="form-group">
                                        <label>Keterangan</label>
                                        <textarea class="form-control form-control-sm"
                                                  name="keterangan"
                                                  rows="3">{{ $item->keterangan }}</textarea>
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
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">

        <form action="{{ url('kategori-barang') }}" method="POST">
            @csrf

            <div class="modal-content">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah Kategori Barang</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body px-4 py-3 bg-light">

                    <div class="mb-3">
                        <button class="btn btn-info btn-sm w-100" disabled>
                            <i class="bi bi-hash"></i> Kode dibuat otomatis
                        </button>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Kategori</label>
                        <input type="text"
                               name="nama_kategori"
                               class="form-control"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Keterangan</label>
                        <textarea name="keterangan"
                                  class="form-control"
                                  rows="3"></textarea>
                    </div>

                </div>

                <div class="modal-footer px-4 pb-3">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>

            </div>

        </form>

    </div>
</div>
@endif

<script>
setTimeout(()=>document.getElementById('toast')?.remove(),3000);

document.getElementById('search').addEventListener('keyup',function(){
    let v=this.value.toLowerCase();
    document.querySelectorAll('#tableBody tr').forEach(r=>{
        r.style.display = r.innerText.toLowerCase().includes(v) ? '' : 'none';
    });
});
</script>

@endsection