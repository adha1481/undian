@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid py-4">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="card-title mb-2">
                                <i class="fas fa-tachometer-alt me-3"></i>
                                Dashboard Admin
                            </h2>
                            <p class="card-text mb-0">
                                Selamat datang, <strong>{{ $user->name }}</strong> - {{ $user->getRoleLabel() }}
                            </p>
                            <small class="opacity-75">
                                <i class="fas fa-clock me-1"></i>
                                Login terakhir: {{ now()->format('d M Y, H:i') }} WIB
                            </small>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="dropdown">
                                <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user-circle me-2"></i>{{ $user->name }}
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('profile') }}">
                                        <i class="fas fa-user me-2"></i>Profil
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="text-primary mb-3">
                        <i class="fas fa-users fa-3x"></i>
                    </div>
                    <h3 class="card-title text-primary">{{ number_format($stats['total_peserta']) }}</h3>
                    <p class="card-text text-muted">Total Peserta</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="text-success mb-3">
                        <i class="fas fa-gift fa-3x"></i>
                    </div>
                    <h3 class="card-title text-success">{{ number_format($stats['total_hadiah']) }}</h3>
                    <p class="card-text text-muted">Total Hadiah</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="text-warning mb-3">
                        <i class="fas fa-trophy fa-3x"></i>
                    </div>
                    <h3 class="card-title text-warning">{{ number_format($stats['total_pemenang']) }}</h3>
                    <p class="card-text text-muted">Total Pemenang</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="text-info mb-3">
                        <i class="fas fa-boxes fa-3x"></i>
                    </div>
                    <h3 class="card-title text-info">{{ number_format($stats['hadiah_tersisa']) }}</h3>
                    <p class="card-text text-muted">Hadiah Tersisa</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt me-2"></i>Aksi Cepat
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Super Admin & Admin Undian -->
                        @if($user->hasAccess('undian'))
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('lottery.index') }}" class="btn btn-outline-primary btn-lg w-100 h-100 d-flex flex-column justify-content-center">
                                <i class="fas fa-dice fa-2x mb-2"></i>
                                <span>Mulai Undian</span>
                            </a>
                        </div>
                        @endif

                        <!-- Super Admin & Admin Peserta -->
                        @if($user->hasAccess('peserta'))
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('participants.index') }}" class="btn btn-outline-success btn-lg w-100 h-100 d-flex flex-column justify-content-center">
                                <i class="fas fa-user-friends fa-2x mb-2"></i>
                                <span>Kelola Peserta</span>
                            </a>
                        </div>
                        @endif

                        <!-- Super Admin & Admin Hadiah -->
                        @if($user->hasAccess('hadiah'))
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('prizes.index') }}" class="btn btn-outline-warning btn-lg w-100 h-100 d-flex flex-column justify-content-center">
                                <i class="fas fa-gift fa-2x mb-2"></i>
                                <span>Kelola Hadiah</span>
                            </a>
                        </div>
                        @endif

                        <!-- Semua Admin -->
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('lottery.winners') }}" class="btn btn-outline-info btn-lg w-100 h-100 d-flex flex-column justify-content-center">
                                <i class="fas fa-crown fa-2x mb-2"></i>
                                <span>Lihat Pemenang</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Role Access Info -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informasi Akses
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary">Role Anda: {{ $user->getRoleLabel() }}</h6>
                            <ul class="list-unstyled">
                                @if($user->hasAccess('undian'))
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Kelola Sistem Undian
                                </li>
                                @endif
                                @if($user->hasAccess('peserta'))
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Kelola Data Peserta
                                </li>
                                @endif
                                @if($user->hasAccess('hadiah'))
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Kelola Data Hadiah
                                </li>
                                @endif
                                @if($user->isSuperAdmin())
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Akses Super Admin
                                </li>
                                @endif
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-info">Fitur Publik</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-eye text-info me-2"></i>
                                    Halaman pemenang dapat diakses tanpa login
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-share text-info me-2"></i>
                                    URL dapat dibagikan ke publik
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-shield-alt me-2"></i>Keamanan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="badge bg-success me-3">
                            <i class="fas fa-check"></i>
                        </div>
                        <div>
                            <small class="text-muted">Status Akun</small>
                            <div class="fw-bold">Aktif</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <div class="badge bg-primary me-3">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div>
                            <small class="text-muted">Level Akses</small>
                            <div class="fw-bold">{{ $user->getRoleLabel() }}</div>
                        </div>
                    </div>

                    <div class="d-grid">
                        <a href="{{ route('profile') }}" class="btn btn-outline-primary">
                            <i class="fas fa-cog me-2"></i>Pengaturan Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
// Auto refresh statistics setiap 30 detik
setInterval(function() {
    // Hanya refresh jika halaman masih aktif
    if (!document.hidden) {
        window.location.reload();
    }
}, 30000);

// Welcome message
@if(session('success'))
    // Show welcome toast
    const toast = new bootstrap.Toast(document.createElement('div'));
@endif
</script>
@endsection
@endsection
