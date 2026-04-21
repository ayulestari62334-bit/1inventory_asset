@extends('layouts.app')

@section('title','Data Warna')

@section('content')

@php
    $isAdmin = auth()->user()->role === 'administrator';
@endphp

<h4 class="mb-3">Data Warna</h4>

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
/* ===== GLOBAL FONT SAMAKAN DENGAN KATEGORI ===== */
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

/* WARNA PREVIEW BOX */
.color-box{
    width:16px;
    height:16px;
    border-radius:4px;
    border:1px solid #ccc;
    display:inline-block;
}
.badge-hex{
    font-size:0.75rem;
    padding:0.15rem 0.25rem;
}

/* MODAL HEADER */
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

/* TABLE FONT DAN PADDING */
.table-sm th,
.table-sm td{
    padding:0.25rem;
    vertical-align:middle;
    font-size:0.78rem;
}

.kode-tipis{
    font-weight:400;
    letter-spacing:.4px;
    text-align:center;
}
</style>

<div class="card shadow-sm">

    <div class="card-header bg-primary py-2 text-white">
        <strong>DATA WARNA</strong>
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

        <p class="mb-2">
            <strong>Total Data :</strong> {{ $warna->count() }}
        </p>

        <table class="table table-bordered table-sm">

            <thead class="bg-primary text-white text-center">
                <tr>
                    <th width="40">No</th>
                    <th>Kode Warna</th>
                    <th>Nama Warna</th>
                    <th>Preview</th>
                    <th>Hex</th>
                    <th>Keterangan</th>
                    @if($isAdmin)
                    <th width="120">Aksi</th>
                    @endif
                </tr>
            </thead>

            <tbody id="tableBody">

            @forelse($warna as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center kode-tipis">{{ $item->kode_warna }}</td>
                    <td>{{ $item->nama_warna }}</td>
                    <td class="text-center">
                        <span class="color-box" style="background: {{ $item->hex_warna }}"></span>
                    </td>
                    <td>
                        <span class="badge badge-dark badge-hex">{{ $item->hex_warna }}</span>
                    </td>
                    <td>{{ $item->keterangan ?? '-' }}</td>

                    @if($isAdmin)
                    <td class="text-center">
                        <div class="d-flex justify-content-center" style="gap:8px">

                            <button class="btn btn-warning btn-sm btn-action"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEdit{{ $item->id }}">
                                <i class="bi bi-pencil-square"></i>
                            </button>

                            <form action="{{ route('warna.destroy',$item->id) }}"
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
                        <form action="{{ route('warna.update',$item->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header py-2">
                                    <h6 class="modal-title">Edit Warna</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Nama Warna</label>
                                        <input type="text"
                                               name="nama_warna"
                                               class="form-control form-control-sm"
                                               value="{{ $item->nama_warna }}"
                                               required>
                                    </div>
                                    <div class="form-group">
                                        <label>Hex Warna</label>
                                        <input type="color"
                                               name="hex_warna"
                                               class="form-control form-control-sm"
                                               value="{{ $item->hex_warna }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Keterangan</label>
                                        <textarea name="keterangan"
                                                  class="form-control form-control-sm"
                                                  rows="2">{{ $item->keterangan }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer py-2">
                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                                        Batal
                                    </button>
                                    <button type="submit" class="btn btn-primary btn-sm">
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
                    <td colspan="{{ $isAdmin ? 7 : 6 }}" class="text-center text-muted">
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
        <form action="{{ route('warna.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h6 class="modal-title">Tambah Data Warna</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <button class="btn btn-info btn-sm btn-block mb-3" disabled>
                        <i class="bi bi-hash"></i> Kode dibuat otomatis
                    </button>
                    <div class="form-group">
                        <label>Nama Warna</label>
                        <input type="text"
                               name="nama_warna"
                               class="form-control form-control-sm"
                               required>
                    </div>
                    <div class="form-group">
                        <label>Hex Warna</label>
                        <input type="color"
                               name="hex_warna"
                               class="form-control form-control-sm">
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan"
                                  class="form-control form-control-sm"
                                  rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
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