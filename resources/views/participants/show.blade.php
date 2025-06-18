@extends('layouts.app')

@section('title', 'Detail Peserta - ' . $participant->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mb-2">
                    <i class="fas fa-user text-primary me-2"></i>
                    Detail Peserta
                </h1>
                <p class="text-muted mb-0">Informasi lengkap peserta undian</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('participants.edit', $participant) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i>
                    Edit Data
                </a>
                <a href="{{ route('participants.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Kembali
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Info Peserta -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Informasi Peserta
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted">Nama Lengkap</h6>
                                <p class="h5 mb-3">{{ $participant->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">Status</h6>
                                @if($participant->has_won)
                                    <span class="badge bg-success fs-6">
                                        <i class="fas fa-crown me-1"></i>Sudah Menang
                                    </span>
                                @else
                                    <span class="badge bg-secondary fs-6">
                                        <i class="fas fa-clock me-1"></i>Belum Menang
                                    </span>
                                @endif
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-12">
                                <h6 class="text-muted">Alamat Lengkap</h6>
                                <p class="mb-0">{{ $participant->address }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Kemenangan -->
                @if($participant->has_won && $participant->winner)
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-trophy me-2"></i>
                                Riwayat Kemenangan
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="bg-warning rounded-circle p-3">
                                        <i class="fas fa-gift text-white fa-2x"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-1">{{ $participant->winner->prize->name }}</h5>
                                    <p class="text-muted mb-1">
                                        Dimenangkan pada: {{ $participant->winner->won_at->format('d F Y, H:i') }}
                                    </p>
                                    @if($participant->winner->prize->description)
                                        <p class="mb-0">
                                            <small class="text-muted">{{ $participant->winner->prize->description }}</small>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar Info -->
            <div class="col-lg-4">
                <!-- Statistik -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-chart-bar me-1"></i>
                            Statistik
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Tanggal Daftar:</span>
                            <small class="text-muted">{{ $participant->created_at->format('d/m/Y') }}</small>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Waktu Daftar:</span>
                            <small class="text-muted">{{ $participant->created_at->format('H:i') }}</small>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Bergabung:</span>
                            <small class="text-muted">{{ $participant->created_at->diffForHumans() }}</small>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <span>ID Peserta:</span>
                            <code>#{{ str_pad($participant->id, 4, '0', STR_PAD_LEFT) }}</code>
                        </div>
                    </div>
                </div>

                <!-- Aksi Cepat -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-bolt me-1"></i>
                            Aksi Cepat
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('participants.edit', $participant) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit me-2"></i>
                                Edit Data Peserta
                            </a>

                            @if(!$participant->has_won)
                                <button class="btn btn-outline-primary btn-sm" onclick="checkLotteryEligibility()">
                                    <i class="fas fa-dice me-2"></i>
                                    Cek Kelayakan Undian
                                </button>

                                <form action="{{ route('participants.destroy', $participant) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus peserta ini? Aksi ini tidak dapat dibatalkan!')"
                                      class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                        <i class="fas fa-trash me-2"></i>
                                        Hapus Peserta
                                    </button>
                                </form>
                            @else
                                <div class="alert alert-info mb-0">
                                    <small>
                                        <i class="fas fa-info-circle me-1"></i>
                                        Peserta ini sudah menang dan tidak dapat dihapus
                                    </small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function checkLotteryEligibility() {
    @if($participant->has_won)
        alert('Peserta ini sudah pernah menang dan tidak dapat ikut undian lagi.');
    @else
        if (confirm('Peserta ini memenuhi syarat untuk ikut undian. Lanjut ke halaman undian?')) {
            window.location.href = '{{ route('lottery.index') }}';
        }
    @endif
}
</script>
@endsection
