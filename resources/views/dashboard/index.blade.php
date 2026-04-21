@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0 text-dark d-flex align-items-center">
            <i class="bi bi-speedometer2 text-primary me-2 fs-4 animate-icon"></i>
            Dashboard Stock Opname
        </h4>
        <span class="badge bg-light text-dark shadow-sm px-3 py-2 rounded">
            {{ now()->translatedFormat('l, d F Y') }}
        </span>
    </div>

    {{-- RINGKASAN --}}
    <div class="row g-4 mb-4">
        @foreach ([
            ['title' => 'Total Session STO', 'value' => $totalSTO, 'icon' => 'bi-clipboard-data', 'color' => 'primary'],
            ['title' => 'Total Barang', 'value' => $totalBarang, 'icon' => 'bi-box-seam', 'color' => 'success'],
            ['title' => 'Total User', 'value' => $totalUser, 'icon' => 'bi-people-fill', 'color' => 'danger'],
        ] as $card)
        <div class="col-md-4">
            <div class="card dashboard-card border-0 shadow-sm hover-gradient hover-shadow animate-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">{{ $card['title'] }}</small>
                        <h2 class="fw-bold text-{{ $card['color'] }} mb-0">{{ $card['value'] }}</h2>
                    </div>
                    <div class="icon-circle bg-{{ $card['color'] }} shadow-sm animate-icon">
                        <i class="bi {{ $card['icon'] }} fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- STATUS --}}
    <div class="row g-4 mb-4 text-center">
        @foreach ([
            ['title' => 'Sangat Layak', 'value' => $sangatLayak, 'bg' => 'bg-success-soft', 'text' => 'text-success'],
            ['title' => 'Cukup Layak', 'value' => $cukupLayak, 'bg' => 'bg-primary-soft', 'text' => 'text-primary'],
            ['title' => 'Layak Pakai', 'value' => $layakPakai, 'bg' => 'bg-primary-soft', 'text' => 'text-primary'],
            ['title' => 'Rusak', 'value' => $rusak, 'bg' => 'bg-warning-soft', 'text' => 'text-warning'],
            ['title' => 'Hilang', 'value' => $hilang, 'bg' => 'bg-danger-soft', 'text' => 'text-danger'],
        ] as $status)
        <div class="col">
            <div class="card dashboard-card {{ $status['bg'] }} shadow-sm py-3 hover-gradient animate-card">
                <small class="text-muted">{{ $status['title'] }}</small>
                <h3 class="fw-bold {{ $status['text'] }}">{{ $status['value'] }}</h3>
            </div>
        </div>
        @endforeach
    </div>

    {{-- GRAFIK --}}
    <div class="card dashboard-card mb-4 border-0 shadow-sm hover-shadow animate-card">
        <div class="card-body">
            <h6 class="fw-bold mb-3">Grafik STO</h6>
            <canvas id="stoChart" height="100"></canvas>
        </div>
    </div>

    {{-- LIST STO --}}
    <div class="card dashboard-card border-0 shadow-sm hover-shadow animate-card">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <span class="fw-bold">List Session Stock Opname</span>

            <button class="btn btn-primary btn-sm shadow-sm rounded-3"
                    data-bs-toggle="modal"
                    data-bs-target="#createSTOModal">
                + Create STO
            </button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle table-striped table-borderless">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Kode STO</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($listSTO as $sto)
                        <tr class="hover-row">
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $sto->kode_sto }}</td>
                            <td>{{ $sto->tanggal }}</td>
                            <td>
                                <span class="badge 
                                    {{ $sto->status == 'Selesai' ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ $sto->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                Belum ada session STO
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- MODAL --}}
<div class="modal fade" id="createSTOModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg animate-card">
            <form action="{{ route('stock-opname.store') }}" method="POST">
                @csrf

                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Create STO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kode STO</label>
                        <input type="text" name="kode_sto"
                               class="form-control rounded-3 shadow-sm"
                               value="STO-{{ date('YmdHis') }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal</label>
                        <input type="date" name="tanggal"
                               class="form-control rounded-3 shadow-sm"
                               value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select rounded-3 shadow-sm">
                            <option value="Draft">Draft</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary rounded-3 shadow-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const data = @json($grafikSTO);
const labels = data.map(item => item.status_barang);
const totals = data.map(item => item.total);

const ctx = document.getElementById('stoChart').getContext('2d');

const gradient = ctx.createLinearGradient(0, 0, 0, 300);
gradient.addColorStop(0, 'rgba(99, 102, 241, 0.9)');
gradient.addColorStop(1, 'rgba(99, 102, 241, 0.2)');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            data: totals,
            backgroundColor: gradient,
            borderRadius: 10,
            borderSkipped: false,
            barThickness: 28,
            hoverBackgroundColor: 'rgba(79, 70, 229, 1)'
        }]
    },
    options: {
        plugins: {
            legend: { display: false }
        },
        scales: {
            x: { grid: { display: false } },
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        }
    }
});
</script>

<style>
.hover-gradient:hover {
    background: linear-gradient(135deg, #4f46e5, #3b82f6);
    color: #fff !important;
    transition: 0.3s;
}

.animate-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.animate-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.15);
}

.animate-icon {
    transition: transform 0.5s ease;
}
.animate-icon:hover {
    transform: rotate(15deg) scale(1.1);
}

.hover-row:hover {
    background: rgba(99,102,241,0.05);
}
</style>
@endpush