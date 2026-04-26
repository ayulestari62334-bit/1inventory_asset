@extends('layouts.app')

@section('title','Data Jenis')

@section('content')

@php
$isAdmin = strtolower(auth()->user()->role ?? '') === 'administrator';
@endphp

<h4 class="mb-3">Data Jenis</h4>

@if(session('success'))
<div class="toast-center toast-success" id="toast">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="toast-center toast-error" id="toast">
    {{ session('error') }}
</div>
@endif

@if ($errors->any())
<div class="toast-center toast-error" id="toast">
    {{ $errors->first() }}
</div>
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

.toast-success{
    background:#28a745;
}

.toast-error{
    background:#dc3545;
}


/* =========================
   MODAL KOTAK PROPORSIONAL
========================= */
.modal-dialog.modal-dialog-centered {
    width: 360px;
    max-width: 100%;
}

.modal-content {
    height: 100%;
    width: 350px;
    display: flex;
    flex-direction: column;
}

.modal-body {
    overflow-y: auto; /* scroll jika isi lebih */
    flex: 1 1 auto;
}

/* batas tinggi input/textarea supaya modal tetap kotak */
.modal-body input,
.modal-body textarea {
    max-height: 100px;
    overflow-y: auto;
}

.kode-tipis{
    font-weight:400;
    letter-spacing:.4px;
    text-align:center;
}

.modal-header{
    background:#0d6efd;
    color:#fff;
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

/* STYLE TABEL */

table{
    font-size:14px;
}

.table thead th{
    text-align:center;
    vertical-align:middle;
}

.table tbody td{
    vertical-align:middle;
}

</style>

<div class="card shadow-sm">

    <div class="card-header bg-primary py-2 text-white">
        <strong>DATA JENIS</strong>
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
            <strong>Total Data :</strong> {{ $jenis->count() }}
        </p>

        <table class="table table-bordered table-sm">

            <thead class="bg-primary text-white text-center">
                <tr>
                    <th width="40">No</th>
                    <th>Kode Jenis</th>
                    <th>Nama</th>
                    <th>Keterangan</th>

                    @if($isAdmin)
                    <th width="120">Aksi</th>
                    @endif
                </tr>
            </thead>

            <tbody id="tableBody">

            @forelse($jenis as $item)

                <tr>

                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td class="text-center kode-tipis">
                        {{ $item->kode_jenis }}
                    </td>

                    <td>
                        {{ $item->nama_jenis }}
                    </td>

                    <td>
                        {{ $item->keterangan ?? '-' }}
                    </td>

                    @if($isAdmin)
                    <td class="text-center">

                        <div class="d-flex justify-content-center" style="gap:8px">

                            <button class="btn btn-warning btn-sm btn-action"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEdit{{ $item->id }}">
                                <i class="bi bi-pencil-square"></i>
                            </button>

                            <form action="{{ route('jenis.destroy',$item->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Hapus data ini?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-danger btn-sm btn-action">
                                    <i class="bi bi-trash3"></i>
                                </button>

                            </form>

                        </div>

                    </td>
                    @endif

                </tr>

                @if($isAdmin)

                <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1">

                    <div class="modal-dialog modal-sm modal-dialog-centered">

                        <form action="{{ route('jenis.update',$item->id) }}" method="POST">

                            @csrf
                            @method('PUT')

                            <div class="modal-content">

                                <div class="modal-header py-2">

                                    <h6 class="modal-title">
                                        Edit Jenis
                                    </h6>

                                    <button type="button"
                                            class="btn-close"
                                            data-bs-dismiss="modal"
                                            aria-label="Close"></button>

                                </div>

                                <div class="modal-body">

                                    <div class="form-group">
                                        <label>Nama Jenis</label>

                                        <input class="form-control form-control-sm"
                                               name="nama_jenis"
                                               value="{{ $item->nama_jenis }}"
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
                    <td colspan="{{ $isAdmin ? 5 : 4 }}"
                        class="text-center text-muted">
                        DATA BELUM TERSEDIA
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>


@if($isAdmin)

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">

        <form action="{{ route('jenis.store') }}" method="POST">
            @csrf

            <div class="modal-content">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah Jenis</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body px-4 py-3 bg-light">

                    <div class="mb-3">
                        <button class="btn btn-info btn-sm w-100" disabled>
                            <i class="bi bi-hash"></i> Kode dibuat otomatis
                        </button>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Jenis</label>
                        <input type="text"
                               name="nama_jenis"
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

setTimeout(()=>{ document.getElementById('toast')?.remove() },3000);

document.getElementById('search')
.addEventListener('keyup',function(){

    let v=this.value.toLowerCase()

    document.querySelectorAll('#tableBody tr')
    .forEach(r=>{ r.style.display = r.innerText.toLowerCase().includes(v) ? '' : 'none'; })

})

</script>

@endsection