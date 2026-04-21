@extends('layouts.app')

@section('content')

<h4 class="mb-3">Edit User</h4>

{{-- ================= TOAST SESSION & VALIDASI ================= --}}
@if ($errors->any())
<div class="toast-center toast-error toast-box">
    {{ $errors->first() }}
</div>
@endif

@if(session('success'))
<div class="toast-center toast-success toast-box">
    {{ session('success') }}
</div>
@endif

@if(session('warning'))
<div class="toast-center toast-warning toast-box">
    {{ session('warning') }}
</div>
@endif

@if(session('error'))
<div class="toast-center toast-error toast-box">
    {{ session('error') }}
</div>
@endif

<style>
.toast-center{
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 16px 26px;
    border-radius: 12px;
    color: #fff;
    font-size: 15px;
    font-weight: 500;
    box-shadow: 0 10px 30px rgba(0,0,0,.35);
    z-index: 9999;
    animation: fadeIn .3s ease;
}
.toast-success{background: linear-gradient(135deg, #4CAF50, #66BB6A);}
.toast-warning{background: linear-gradient(135deg, #ff9800, #ffb74d);}
.toast-error{background: linear-gradient(135deg, #f44336, #e57373);}
@keyframes fadeIn {
    from {opacity: 0; transform: translate(-50%, -45%);}
    to {opacity: 1; transform: translate(-50%, -50%);}
}
</style>

<div class="card">
    <div class="card-header bg-primary py-2 text-white">
        <strong>EDIT DATA USER</strong>
    </div>

    <div class="card-body pt-3">
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div class="form-group mb-2">
                <label>Nama</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ old('name', $user->name) }}"
                       required>
            </div>

            {{-- Email --}}
            <div class="form-group mb-2">
                <label>Email</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       value="{{ old('email', $user->email) }}"
                       required>
            </div>

            {{-- ROLE (HANYA ADMIN BOLEH LIHAT & UBAH) --}}
            @if(strtolower(auth()->user()->role) === 'administrator')
                <div class="form-group mb-2">
                    <label>Role</label>
                    <select name="role" class="form-control" required>
                        <option value="administrator" {{ old('role', $user->role) === 'administrator' ? 'selected' : '' }}>
                            Administrator
                        </option>
                        <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>
                            User
                        </option>
                    </select>
                </div>
            @endif

            {{-- BUTTON --}}
            <div class="mt-3">
                <button class="btn btn-primary">
                    <i class="bi bi-save"></i> Update
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
            </div>

        </form>
    </div>
</div>

<script>
setTimeout(() => {
    document.querySelectorAll('.toast-box').forEach(t => t.remove());
}, 3000);
</script>

@endsection