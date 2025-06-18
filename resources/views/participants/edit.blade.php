@extends('layouts.app')

@section('title', 'Edit Peserta')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">
                    <i class="fas fa-user-edit me-2"></i>
                    Edit Data Peserta
                </h4>
            </div>

            <div class="card-body">
                <form action="{{ route('participants.update', $participant) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nama Peserta -->
                    <div class="mb-3">
                        <label for="name" class="form-label">
                            <i class="fas fa-user me-1"></i>
                            Nama Lengkap <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name"
                               name="name"
                               value="{{ old('name', $participant->name) }}"
                               placeholder="Masukkan nama lengkap peserta"
                               required>
                        @error('name')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Nama akan ditampilkan dalam undian
                        </div>
                    </div>

                    <!-- Alamat Peserta -->
                    <div class="mb-4">
                        <label for="address" class="form-label">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            Alamat Lengkap <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control @error('address') is-invalid @enderror"
                                  id="address"
                                  name="address"
                                  rows="4"
                                  placeholder="Masukkan alamat lengkap peserta"
                                  required>{{ old('address', $participant->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Alamat diperlukan untuk pengiriman hadiah jika menang
                        </div>
                    </div>

                    <hr>

                    <!-- Status Info -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Status Peserta</h6>
                                    @if($participant->has_won)
                                        <span class="badge bg-success">
                                            <i class="fas fa-crown me-1"></i>Sudah Menang
                                        </span>
                                        <p class="text-muted mt-2 mb-0">
                                            <small>Peserta ini sudah pernah memenangkan hadiah</small>
                                        </p>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-clock me-1"></i>Belum Menang
                                        </span>
                                        <p class="text-muted mt-2 mb-0">
                                            <small>Peserta ini masih bisa ikut undian</small>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Tanggal Daftar</h6>
                                    <p class="mb-0">{{ $participant->created_at->format('d F Y, H:i') }}</p>
                                    <p class="text-muted mb-0">
                                        <small>{{ $participant->created_at->diffForHumans() }}</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Info Ketentuan -->
                    @if($participant->has_won)
                        <div class="alert alert-warning">
                            <h6><i class="fas fa-exclamation-triangle me-2"></i>Perhatian:</h6>
                            <p class="mb-0">
                                Peserta ini sudah pernah menang. Perubahan data hanya untuk keperluan administrasi.
                                Peserta tidak akan ikut dalam undian selanjutnya.
                            </p>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle me-2"></i>Ketentuan Undian:</h6>
                            <ul class="mb-0">
                                <li>Setiap peserta hanya bisa menang <strong>1 kali</strong></li>
                                <li>Peserta yang sudah menang tidak bisa ikut undian lagi</li>
                                <li>Pastikan data yang dimasukkan sudah benar</li>
                            </ul>
                        </div>
                    @endif

                    <!-- Tombol Aksi -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('participants.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>
                            Batal
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-2"></i>
                            Update Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Auto-capitalize nama
    $('#name').on('input', function() {
        let value = $(this).val();
        // Capitalize first letter of each word
        value = value.toLowerCase().replace(/\b\w/g, l => l.toUpperCase());
        $(this).val(value);
    });

    // Character counter untuk alamat
    $('#address').on('input', function() {
        const maxLength = 1000;
        const currentLength = $(this).val().length;
        const remaining = maxLength - currentLength;

        // Remove existing counter
        $(this).next('.form-text').find('.char-counter').remove();

        // Add character counter
        if (currentLength > maxLength * 0.8) {
            const color = remaining < 50 ? 'text-warning' : 'text-muted';
            $(this).next('.form-text').append(
                `<span class="char-counter ${color}"> | ${remaining} karakter tersisa</span>`
            );
        }
    });

    // Form validation
    $('form').on('submit', function(e) {
        let isValid = true;

        // Validasi nama (minimal 2 kata)
        const name = $('#name').val().trim();
        const nameWords = name.split(' ').filter(word => word.length > 0);

        if (nameWords.length < 2) {
            e.preventDefault();
            isValid = false;

            $('#name').addClass('is-invalid');
            $('#name').next('.invalid-feedback').remove();
            $('#name').after('<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>Nama harus terdiri dari minimal 2 kata</div>');
        } else {
            $('#name').removeClass('is-invalid');
        }

        // Validasi alamat (minimal 10 karakter)
        const address = $('#address').val().trim();
        if (address.length < 10) {
            e.preventDefault();
            isValid = false;

            $('#address').addClass('is-invalid');
            $('#address').next('.invalid-feedback').remove();
            $('#address').after('<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>Alamat harus minimal 10 karakter</div>');
        } else {
            $('#address').removeClass('is-invalid');
        }

        // Show loading if valid
        if (isValid) {
            $(this).find('button[type="submit"]').html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...').prop('disabled', true);
        }
    });
});
</script>
@endsection
