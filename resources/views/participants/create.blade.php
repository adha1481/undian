@extends('layouts.app')

@section('title', 'Tambah Peserta Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <i class="fas fa-user-plus me-2"></i>
                    Pendaftaran Peserta Undian
                </h4>
            </div>

            <div class="card-body">
                <form action="{{ route('participants.store') }}" method="POST">
                    @csrf

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
                               value="{{ old('name') }}"
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

                    <!-- Unit Peserta -->
                    <div class="mb-4">
                        <label for="address" class="form-label">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            Nasabah Unit  <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control @error('address') is-invalid @enderror"
                                  id="address"
                                  name="address"
                                  rows="4"
                                  placeholder="Masukkan BRI Unit Binaan"
                                  required>{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Unit diperlukan untuk pengiriman hadiah jika menang
                        </div>
                    </div>

                    <hr>

                    <!-- Info Ketentuan -->
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle me-2"></i>Ketentuan Undian:</h6>
                        <ul class="mb-0">
                            <li>Setiap peserta hanya bisa menang <strong>1 kali</strong></li>
                            <li>Peserta yang sudah menang tidak bisa ikut undian lagi</li>
                            <li>Data peserta tidak dapat diubah setelah menang</li>
                            <li>Pastikan data yang dimasukkan sudah benar</li>
                        </ul>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('participants.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Daftarkan Peserta
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

    // Character counter untuk Unit
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

        // Validasi Unit (minimal 10 karakter)
        const address = $('#address').val().trim();
        if (address.length < 10) {
            e.preventDefault();
            isValid = false;

            $('#address').addClass('is-invalid');
            $('#address').next('.invalid-feedback').remove();
            $('#address').after('<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>Unit harus minimal 10 karakter</div>');
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
