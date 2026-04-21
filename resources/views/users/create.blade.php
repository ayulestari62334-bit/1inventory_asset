@extends('layouts.app')

@section('content')

<h4>Tambah User</h4>

{{-- ================= POPUP VALIDASI ERROR ================= --}}
@if ($errors->any())
<div class="toast-center toast-error toast-box">
    Data sudah ada atau input tidak valid!
</div>
@endif

{{-- ================= TOAST SESSION ================= --}}
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

.toast-success{
    background: linear-gradient(135deg, #4CAF50, #66BB6A);
}
.toast-warning{
    background: linear-gradient(135deg, #ff9800, #ffb74d);
}
.toast-error{
    background: linear-gradient(135deg, #f44336, #e57373);
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translate(-50%, -45%);
    }
    to {
        opacity: 1;
        transform: translate(-50%, -50%);
    }
}
</style>

<form action="{{ route('users.store') }}" method="POST">
@csrf

<input type="text"
       name="name"
       class="form-control mb-2"
       placeholder="Nama"
       value="{{ old('name') }}"
       required>

<input type="email"
       name="email"
       class="form-control mb-2"
       placeholder="Email"
       value="{{ old('email') }}"
       required>

{{-- PASSWORD MODERN --}}
<div class="input-group mb-2">
    <input type="password"
           name="password"
           id="password"
           class="form-control"
           placeholder="Password"
           required>

    <span class="input-group-text bg-white"
          style="cursor:pointer"
          onclick="togglePassword()">
        <i class="bi bi-eye" id="eyeIcon"></i>
    </span>
</div>

<select name="role" class="form-control mb-2" required>
    <option value="">-- Pilih Role --</option>
    <option value="admin" {{ old('role')=='admin'?'selected':'' }}>Admin</option>
    <option value="user" {{ old('role')=='user'?'selected':'' }}>User</option>
</select>

<button class="btn btn-primary">Simpan</button>
<a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
</form>

<script>
function togglePassword(){
    const pw   = document.getElementById('password');
    const eye  = document.getElementById('eyeIcon');

    if(pw.type === 'password'){
        pw.type = 'text';
        eye.classList.remove('bi-eye');
        eye.classList.add('bi-eye-slash');
    }else{
        pw.type = 'password';
        eye.classList.remove('bi-eye-slash');
        eye.classList.add('bi-eye');
    }
}

setTimeout(() => {
    document.querySelectorAll('.toast-box').forEach(t => t.remove());
}, 3000);
</script>

@endsection
