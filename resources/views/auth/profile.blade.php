@extends('layouts.app')

@section('title', 'Profil Admin')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body p-4">
                    <h2 class="card-title mb-2">
                        <i class="fas fa-user-circle me-3"></i>
                        Profil Admin
                    </h2>
                    <p class="card-text mb-0">
                        Kelola informasi profil dan keamanan akun Anda
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Informasi Profil -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-id-card me-2"></i>Informasi Akun
                    </h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-4">
                        <div class="avatar-circle bg-primary text-white d-inline-flex align-items-center justify-content-center"
                             style="width: 100px; height: 100px; border-radius: 50%; font-size: 2rem;">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                    </div>

                    <h4 class="mb-2">{{ $user->name }}</h4>
                    <p class="text-muted mb-3">{{ $user->email }}</p>

                    <div class="badge bg-primary p-2 mb-3">
                        <i class="fas fa-user-shield me-2"></i>
                        {{ $user->getRoleLabel() }}
                    </div>

                    <div class="row text-center">
                        <div class="col">
                            <div class="border rounded p-3">
                                <div class="text-success mb-1">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                                <small class="text-muted">Status</small>
                                <div class="fw-bold">
                                    {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="border rounded p-3">
                                <div class="text-info mb-1">
                                    <i class="fas fa-calendar fa-2x"></i>
                                </div>
                                <small class="text-muted">Bergabung</small>
                                <div class="fw-bold">
                                    {{ $user->created_at->format('M Y') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Edit Profil -->
        <div class="col-lg-8">
            <div class="row">
                <!-- Edit Data Profil -->
                <div class="col-12 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom-0">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-edit me-2"></i>Edit Profil
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('profile.update') }}">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">
                                            <i class="fas fa-user me-2"></i>Nama Lengkap
                                        </label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">
                                            <i class="fas fa-envelope me-2"></i>Email
                                        </label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                               id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">
                                            <i class="fas fa-user-shield me-2"></i>Role
                                        </label>
                                        <input type="text" class="form-control" value="{{ $user->getRoleLabel() }}" readonly>
                                        <div class="form-text">Role tidak dapat diubah</div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">
                                            <i class="fas fa-toggle-on me-2"></i>Status
                                        </label>
                                        <input type="text" class="form-control" value="{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}" readonly>
                                        <div class="form-text">Status dikelola oleh Super Admin</div>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Ubah Password -->
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom-0">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-key me-2"></i>Ubah Password
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('profile.update') }}">
                                @csrf
                                @method('PUT')

                                <!-- Hidden fields untuk nama dan email -->
                                <input type="hidden" name="name" value="{{ $user->name }}">
                                <input type="hidden" name="email" value="{{ $user->email }}">

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="current_password" class="form-label">
                                            <i class="fas fa-lock me-2"></i>Password Lama
                                        </label>
                                        <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                               id="current_password" name="current_password" placeholder="Masukkan password lama">
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Kosongkan jika tidak ingin mengubah password</div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="new_password" class="form-label">
                                            <i class="fas fa-key me-2"></i>Password Baru
                                        </label>
                                        <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                               id="new_password" name="new_password" placeholder="Minimal 6 karakter">
                                        @error('new_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="new_password_confirmation" class="form-label">
                                            <i class="fas fa-key me-2"></i>Konfirmasi Password Baru
                                        </label>
                                        <input type="password" class="form-control"
                                               id="new_password_confirmation" name="new_password_confirmation"
                                               placeholder="Ulangi password baru">
                                    </div>
                                </div>

                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Tips Keamanan:</strong>
                                    <ul class="mb-0 mt-2">
                                        <li>Gunakan password minimal 6 karakter</li>
                                        <li>Kombinasikan huruf besar, kecil, angka, dan simbol</li>
                                        <li>Jangan gunakan informasi pribadi yang mudah ditebak</li>
                                    </ul>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-shield-alt me-2"></i>Ubah Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
// Show/hide password
document.addEventListener('DOMContentLoaded', function() {
    // Add show/hide password functionality
    const passwordInputs = document.querySelectorAll('input[type="password"]');

    passwordInputs.forEach(input => {
        const container = input.parentElement;
        const toggleBtn = document.createElement('button');
        toggleBtn.type = 'button';
        toggleBtn.className = 'btn btn-outline-secondary btn-sm position-absolute end-0 top-50 translate-middle-y me-1';
        toggleBtn.innerHTML = '<i class="fas fa-eye"></i>';
        toggleBtn.style.zIndex = '10';

        container.style.position = 'relative';
        container.appendChild(toggleBtn);

        toggleBtn.addEventListener('click', function() {
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);

            const icon = this.querySelector('i');
            icon.className = type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
        });
    });
});
</script>
@endsection
@endsection
