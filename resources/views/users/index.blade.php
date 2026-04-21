@extends('layouts.app')

@section('content')

@php
    $isAdmin = strtolower(auth()->user()->role ?? '') === 'administrator';
@endphp

<h4 class="mb-3">Master Users</h4>

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
.modal-header .btn-close{
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
        <strong>DATA USERS</strong>
    </div>

    <div class="card-body">

        {{-- SEARCH + TOMBOL --}}
        <div class="d-flex justify-content-between mb-2">
            @if($isAdmin)
            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
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
            <strong>Total Data :</strong> {{ $users->count() }}
        </p>

        <table class="table table-bordered table-sm">
            <thead class="bg-primary text-white text-center">
                <tr>
                    <th width="40">No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    @if($isAdmin)
                    <th width="120">Aksi</th>
                    @endif
                </tr>
            </thead>

            <tbody id="tableBody">
            @forelse($users as $u)

                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td class="text-center">
                        <span class="badge bg-{{ strtolower($u->role)=='administrator'?'success':'secondary' }}">
                            {{ ucfirst($u->role) }}
                        </span>
                    </td>

                    @if($isAdmin)
                    <td class="text-center">
                        <div class="d-flex justify-content-center" style="gap:8px">

                            <button class="btn btn-warning btn-sm btn-action"
                                    data-bs-toggle="modal"
                                    data-bs-target="#edit{{ $u->id }}">
                                <i class="bi bi-pencil-square"></i>
                            </button>

                            @if(auth()->id() !== $u->id)
                            <form action="{{ route('users.destroy',$u->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Hapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm btn-action">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                            @endif

                        </div>
                    </td>
                    @endif
                </tr>

                {{-- MODAL EDIT --}}
                @if($isAdmin)
                <div class="modal fade" id="edit{{ $u->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered" style="max-width:500px;">

                        <form action="{{ route('users.update',$u->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="modal-content">
                                <div class="modal-header py-2">
                                    <h6 class="modal-title">Edit User</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input class="form-control form-control-sm"
                                               name="name"
                                               value="{{ $u->name }}"
                                               required>
                                    </div>

                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email"
                                               class="form-control form-control-sm"
                                               name="email"
                                               value="{{ $u->email }}"
                                               required>
                                    </div>

                                    <div class="form-group">
                                        <label>Role</label>
                                        <select name="role"
                                                class="form-control form-control-sm"
                                                required>
                                            <option value="administrator" {{ strtolower($u->role)=='administrator'?'selected':'' }}>Administrator</option>
                                            <option value="user" {{ strtolower($u->role)=='user'?'selected':'' }}>User</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="modal-footer py-2">
                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                                        Batal
                                    </button>
                                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                                </div>

                            </div>

                        </form>

                    </div>
                </div>
                @endif

            @empty
                <tr>
                    <td colspan="{{ $isAdmin ? 5 : 4 }}" class="text-center text-muted">
                        DATA KOSONG
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

    </div>
</div>

{{-- ================= MODAL TAMBAH ================= --}}
<div class="modal fade" id="modalTambahUser" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Tambah User</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="modal-body px-4 py-3 bg-light">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="passwordTambah" class="form-control" required>

                        <span class="input-group-text bg-white"
                              onclick="togglePassword('passwordTambah','eyeTambah')"
                              style="cursor:pointer">
                            <i class="bi bi-eye" id="eyeTambah"></i>
                        </span>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Role</label>
                    <select name="role" class="form-select" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="admin">Administrator</option>
                        <option value="user">User</option>
                    </select>
                </div>

            </div>

            <div class="modal-footer px-4 pb-3">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-primary">Simpan</button>
            </div>

            </form>

        </div>
    </div>
</div>


<script>
setTimeout(()=>document.querySelectorAll('.toast-msg').forEach(el=>el.remove()),3000);

// SEARCH REALTIME
document.getElementById('search').addEventListener('keyup', function(){
    let v = this.value.toLowerCase();
    document.querySelectorAll('#tableBody tr').forEach(r=>{
        r.style.display = r.innerText.toLowerCase().includes(v) ? '' : 'none';
    });
});
</script>

@endsection