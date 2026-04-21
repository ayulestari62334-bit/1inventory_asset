@extends('layouts.app')

@section('content')

<style>
    .asset-container {
        max-width: 1100px;
        margin: auto;
    }

    .asset-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(30, 58, 138, 0.08);
        overflow: hidden;
    }

    .asset-header {
        padding: 25px 35px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .asset-title {
        font-weight: 600;
        font-size: 20px;
        color: #1e3a8a;
    }

    .asset-id {
        font-size: 14px;
        color: #475569;
    }

    .info-item {
        padding: 14px 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .info-label {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: #64748b;
    }

    .info-value {
        font-weight: 500;
        color: #1e3a8a;
        margin-top: 4px;
    }

    .status-badge {
        padding: 6px 18px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
        color: white;
        background: #1e3a8a;
    }

    .status-sto {
        background: #2563eb;
    }

    .back-btn {
        background: #1e3a8a;
        color: white;
        padding: 8px 22px;
        border-radius: 8px;
        text-decoration: none;
        transition: 0.2s ease-in-out;
        display: inline-block;
    }

    .back-btn:hover {
        background: #2563eb;
        color: white;
    }

    .no-image {
        height: 240px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e2e8f0;
        border-radius: 12px;
        color: #1e3a8a;
        font-weight: 500;
    }
</style>

<div class="container mt-4">
<div class="asset-container">

<div class="asset-card">

    {{-- HEADER --}}
    <div class="asset-header">
        <div>
            <div class="asset-title">Asset Detail</div>
            <div class="asset-id">
                ID : {{ $barang->no_asset }}
            </div>
        </div>

        <div>
            <span class="status-badge 
                @if($barang->status_barang == 'STO') status-sto @endif">
                {{ $barang->status_barang }}
            </span>
        </div>
    </div>

    {{-- BODY --}}
    <div class="p-4">
        <div class="row">

            {{-- FOTO --}}
            <div class="col-md-4 text-center mb-4">
                @if(!empty($barang->foto) && file_exists(public_path('barang/'.$barang->foto)))
                    <img src="{{ asset('barang/'.$barang->foto) }}"
                         alt="Foto Barang"
                         class="img-fluid rounded-3 shadow-sm"
                         style="max-height:240px; object-fit:cover;">
                @else
                    <div class="no-image">
                        Tidak ada gambar
                    </div>
                @endif
            </div>

            {{-- DETAIL --}}
            <div class="col-md-8">

                @php
                    $fields = [
                        'Kategori' => $barang->kategori?->nama_kategori ?? '-',
                        'Jenis' => $barang->jenis?->nama_jenis ?? '-',
                        'Merek' => $barang->merek?->nama_merek ?? '-',
                        'Warna' => $barang->warna?->nama_warna ?? '-',
                        'Lokasi' => $barang->lokasi?->nama_lokasi ?? '-',
                        'Karyawan' => $barang->karyawan?->nama_karyawan ?? '-',
                        'Divisi' => $barang->karyawan?->divisi?->nama_divisi ?? '-',
                        'Serial' => $barang->serial_number ?? '-',
                        'Licence' => $barang->jenis_licence ?? '-',
                        'Kode' => $barang->kode_licence ?? '-',
                        'Tanggal Masuk' => $barang->tanggal_masuk ?? '-',
                    ];
                @endphp

                <div class="row">
                    @foreach($fields as $label => $value)
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">
                                    {{ $label }}
                                </div>
                                <div class="info-value">
                                    {{ $value }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>

        </div>
    </div>

</div>

<div class="mt-4">
    <a href="{{ route('barang.index') }}" class="back-btn">
        ← Back
    </a>
</div>

</div>
</div>

@endsection
