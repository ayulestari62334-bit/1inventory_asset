@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <h4 class="mb-3 fw-bold">
        Detail STO - {{ $sto->kode_sto }}
    </h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Stok Sistem</th>
                        <th>Stok Fisik</th>
                        <th>Status</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sto->details as $d)
                        <tr>
                            <td>{{ $d->barang->nama }}</td>
                            <td>{{ $d->stok_sistem }}</td>
                            <td>
                                @if($d->status == 'pending')
                                    <form action="{{ route('sto.updateDetail',$d->id) }}" method="POST">
                                        @csrf
                                        <input type="number"
                                               name="stok_fisik"
                                               class="form-control"
                                               required>
                                @else
                                    {{ $d->stok_fisik }}
                                @endif
                            </td>
                            <td>
                                @if($d->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @else
                                    <span class="badge bg-success">Done</span>
                                @endif
                            </td>
                            <td>
                                @if($d->status == 'pending')
                                    <button type="submit"
                                            class="btn btn-success btn-sm">
                                        Simpan
                                    </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <hr>

            <form action="{{ route('sto.close',$sto->id) }}" method="POST">
                @csrf
                <button class="btn btn-danger">
                    Tutup STO
                </button>
            </form>

        </div>
    </div>

</div>
@endsection
