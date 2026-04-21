@extends('layouts.app')

@section('title','Data Stock Opname')

@section('content')

<h4 class="mb-3">Data Stock Opname</h4>

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
</style>

<div class="card shadow-sm">
    <div class="card-header bg-primary py-2 text-white">
        <strong>DATA STOCK OPNAME</strong>
    </div>

    <div class="card-body">

        <div class="d-flex justify-content-between mb-2">
            <button class="btn btn-success btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#modalTambah">
                <i class="bi bi-plus-circle"></i> Tambah
            </button>

            <input type="text"
                   id="search"
                   class="form-control form-control-sm w-25"
                   placeholder="Cari data...">
        </div>

        <p class="mb-2"><strong>Total Data :</strong> {{ $stockOpnames->count() }}</p>

        <table class="table table-bordered table-sm">
            <thead class="bg-primary text-white text-center">
                <tr>
                    <th width="40">No</th>
                    <th>Kode STO</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>

            <tbody id="tableBody">

            @forelse($stockOpnames as $s)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $s->kode_sto }}</td>
                    <td>{{ \Carbon\Carbon::parse($s->tanggal)->format('d-m-Y') }}</td>
                    <td class="text-center">
                        @if(strtolower($s->status) == 'proses')
                            <span class="badge bg-warning text-dark">Proses</span>
                        @else
                            <span class="badge bg-success">Selesai</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center" style="gap:8px">

                            {{-- SELESAI --}}
                            @if(strtolower($s->status) == 'proses')
                            <form action="{{ route('stock-opname.close', $s->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-info btn-sm btn-action" type="submit" title="Selesaikan Stock Opname">
                                    <i class="bi bi-check-circle"></i>
                                </button>
                            </form>
                            @endif

                            {{-- DELETE --}}
                            <form action="{{ route('stock-opname.destroy', $s->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Hapus data?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm btn-action" title="Hapus Stock Opname">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        DATA KOSONG
                    </td>
                </tr>
            @endforelse

            </tbody>
        </table>
    </div>
</div>

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog modal-sm">
        <form action="{{ route('stock-opname.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h6 class="modal-title">Tambah Stock Opname</h6>
                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date"
                               class="form-control form-control-sm"
                               name="tanggal"
                               required>
                    </div>

                </div>

                <div class="modal-footer py-2">
                    <button type="button"
                            class="btn btn-secondary btn-sm"
                            data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button class="btn btn-primary btn-sm" type="submit">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
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