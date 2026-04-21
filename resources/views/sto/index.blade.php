@extends('layouts.app')

@section('content')
<div class="container-fluid">

<h4 class="mb-3 fw-bold">Data Stock Opname</h4>

{{-- Alert sukses --}}
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

{{-- Alert error --}}
@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <span class="fw-bold">DATA STOCK OPNAME</span>

        @php
            $stoAktif = $stock->where('status', 'Proses')->count();
        @endphp

        @if($stoAktif == 0)
            <a href="{{ route('sto.create') }}" class="btn btn-success btn-sm">
                + Tambah
            </a>
        @else
            <button class="btn btn-secondary btn-sm" disabled>
                STO Masih Berjalan
            </button>
        @endif
    </div>

    <div class="card-body">

        <p>Total Data : <strong>{{ $stock->count() }}</strong></p>

        <table class="table table-bordered table-striped">
            <thead class="bg-primary text-white text-center">
                <tr>
                    <th>No</th>
                    <th>Kode STO</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th width="220">Aksi</th>
                </tr>
            </thead>
            <tbody>

            @forelse($stock as $s)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $s->kode_sto }}</td>
                <td>{{ \Carbon\Carbon::parse($s->tanggal)->format('d-m-Y') }}</td>
                <td>
                    @if($s->status === 'Proses')
                        <span class="badge bg-warning text-dark">Proses</span>
                    @else
                        <span class="badge bg-success">Selesai</span>
                    @endif
                </td>
                <td class="text-center">

                    <a href="{{ route('sto.show', $s->id) }}" class="btn btn-info btn-sm">
                        👁 Detail
                    </a>

                    @if($s->status === 'Proses')
                    <form action="{{ route('sto.close', $s->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-success btn-sm"
                                onclick="return confirm('Selesaikan Stock Opname ini?')">
                            ✔ Selesai
                        </button>
                    </form>
                    @endif

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center text-muted">
                    Belum ada data Stock Opname
                </td>
            </tr>
            @endforelse

            </tbody>
        </table>

    </div>
</div>
</div>
@endsection
