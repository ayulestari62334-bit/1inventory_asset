@extends('layouts.app')

@section('content')

@php
    $isAdmin = strtolower(auth()->user()->role ?? '') === 'administrator';
@endphp

<h4 class="mb-3">Master Karyawan</h4>

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

.modal-header{
    background:#0d6efd;
    color:#fff;
}

.modal-header .close, .modal-header .btn-close{
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

/* TABLE */
.table-sm th, .table-sm td{
    padding:0.35rem;
    vertical-align:middle;
    font-size:0.875rem;
}
.table thead th{
    text-align:center;
}
</style>

<div class="card shadow-sm">

    <div class="card-header bg-primary py-2 text-white">
        <strong>DATA KARYAWAN</strong>
    </div>

    <div class="card-body">

        {{-- SEARCH + TOMBOL --}}
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
            <strong>Total Data :</strong> {{ $karyawan->count() }}
        </p>

        <table class="table table-bordered table-sm">

            <thead class="bg-primary text-white text-center">
                <tr>
                    <th width="40">No</th>
                    <th>ID Karyawan</th>
                    <th>Nama Karyawan</th>
                    <th>Divisi</th>
                    @if($isAdmin)
                    <th width="120">Aksi</th>
                    @endif
                </tr>
            </thead>

            <tbody id="tableBody">
            @forelse($karyawan as $item)

                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $item->id_karyawan ?? '-' }}</td>
                    <td>{{ $item->nama_karyawan }}</td>
                    <td>{{ optional($item->divisi)->nama_divisi ?? '-' }}</td>

                    @if($isAdmin)
                    <td class="text-center">
                        <div class="d-flex justify-content-center" style="gap:8px">

                            <button class="btn btn-warning btn-sm btn-action"
                                    data-bs-toggle="modal"
                                    data-bs-target="#edit{{ $item->id }}">
                                <i class="bi bi-pencil-square"></i>
                            </button>

                            <form action="{{ route('karyawan.destroy',$item->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Hapus data?')">
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

                {{-- MODAL EDIT --}}
                @if($isAdmin)
                <div class="modal fade" id="edit{{ $item->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered" style="max-width:360px;">

                        <form action="{{ route('karyawan.update',$item->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="modal-content">

                                <div class="modal-header py-2">
                                    <h6 class="modal-title">Edit Karyawan</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">

                                    <div class="form-group">
                                        <label>Nama Karyawan</label>
                                        <input type="text"
                                               class="form-control form-control-sm"
                                               name="nama_karyawan"
                                               value="{{ $item->nama_karyawan }}"
                                               required>
                                    </div>

                                    <div class="form-group">
                                        <label>Divisi</label>
                                        <select name="divisi_id"
                                                class="form-control form-control-sm"
                                                required>
                                            @foreach($divisi as $d)
                                            <option value="{{ $d->id }}"
                                            {{ $item->divisi_id == $d->id ? 'selected' : '' }}>
                                                {{ $d->nama_divisi }}
                                            </option>
                                            @endforeach
                                        </select>
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
                        DATA KOSONG
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
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Tambah Karyawan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('karyawan.store') }}" method="POST">
            @csrf

            <div class="modal-body px-4 py-3 bg-light">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Karyawan</label>
                    <input type="text"
                           name="nama_karyawan"
                           class="form-control"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Divisi</label>
                    <select name="divisi_id"
                            class="form-select"
                            required>
                        <option value="">-- Pilih Divisi --</option>
                        @foreach($divisi as $d)
                        <option value="{{ $d->id }}">{{ $d->nama_divisi }}</option>
                        @endforeach
                    </select>
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

            </form>

        </div>
    </div>
</div>
@endif

<script>
setTimeout(()=>document.querySelectorAll('.toast-msg').forEach(el=>el.remove()),3000);

document.getElementById('search').addEventListener('keyup',function(){
    let v=this.value.toLowerCase();
    document.querySelectorAll('#tableBody tr').forEach(r=>{
        r.style.display = r.innerText.toLowerCase().includes(v) ? '' : 'none';
    });
});
</script>

@endsection