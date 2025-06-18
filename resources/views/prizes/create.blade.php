@extends('layouts.app')

@section('title', 'Tambah Hadiah Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <i class="fas fa-trophy me-2"></i>
                    Tambah Hadiah Undian
                </h4>
            </div>

            <div class="card-body">
                <form action="{{ route('prizes.store') }}" method="POST">
                    @csrf

                    <!-- Nama Hadiah -->
                    <div class="mb-3">
                        <label for="name" class="form-label">
                            <i class="fas fa-gift me-1"></i>
                            Nama Hadiah <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name"
                               name="name"
                               value="{{ old('name') }}"
                               placeholder="Contoh: iPhone 15, Laptop Gaming, Voucher Belanja"
                               required>
                        @error('name')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Nama hadiah akan ditampilkan dalam undian
                        </div>
                    </div>

                    <!-- Jumlah Hadiah -->
                    <div class="mb-3">
                        <label for="quantity" class="form-label">
                            <i class="fas fa-sort-numeric-up me-1"></i>
                            Jumlah Hadiah <span class="text-danger">*</span>
                        </label>
                        <input type="number"
                               class="form-control @error('quantity') is-invalid @enderror"
                               id="quantity"
                               name="quantity"
                               value="{{ old('quantity', 1) }}"
                               min="1"
                               max="1000"
                               placeholder="Masukkan jumlah hadiah yang tersedia"
                               required>
                        @error('quantity')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Jumlah hadiah yang bisa dimenangkan dalam undian
                        </div>
                    </div>

                    <!-- Deskripsi Hadiah -->
                    <div class="mb-3">
                        <label for="description" class="form-label">
                            <i class="fas fa-align-left me-1"></i>
                            Deskripsi Hadiah <span class="text-muted">(Opsional)</span>
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description"
                                  name="description"
                                  rows="3"
                                  placeholder="Deskripsi detail hadiah, spesifikasi, atau catatan khusus">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Informasi tambahan tentang hadiah (maksimal 1000 karakter)
                        </div>
                    </div>

                    <!-- Status Aktif -->
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="is_active"
                                   name="is_active"
                                   value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                <i class="fas fa-toggle-on me-1"></i>
                                Aktifkan hadiah untuk undian
                            </label>
                        </div>
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Hanya hadiah yang aktif yang dapat digunakan dalam undian
                        </div>
                    </div>

                    <hr>

                    <!-- Info Ketentuan -->
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle me-2"></i>Ketentuan Hadiah:</h6>
                        <ul class="mb-0">
                            <li>Pastikan nama hadiah <strong>unik dan jelas</strong></li>
                            <li>Jumlah hadiah dapat diubah selama belum ada pemenang</li>
                            <li>Hadiah nonaktif tidak akan muncul dalam pilihan undian</li>
                            <li>Hadiah dengan pemenang tidak dapat dihapus</li>
                        </ul>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('prizes.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Simpan Hadiah
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Preview Hadiah -->
        <div class="card mt-4" id="prizePreview" style="display: none;">
            <div class="card-header bg-light">
                <h6 class="mb-0">
                    <i class="fas fa-eye me-1"></i>
                    Preview Hadiah
                </h6>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar-lg bg-warning rounded-circle d-flex align-items-center justify-content-center me-3">
                        <i class="fas fa-gift text-white fa-2x"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="mb-1" id="previewName">-</h5>
                        <p class="text-muted mb-1" id="previewDescription">-</p>
                        <div class="d-flex gap-2">
                            <span class="badge bg-light text-dark" id="previewQuantity">0 unit</span>
                            <span class="badge bg-success" id="previewStatus">Aktif</span>
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
$(document).ready(function() {
    // Character counter untuk deskripsi
    $('#description').on('input', function() {
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

        updatePreview();
    });

    // Update preview saat input berubah
    $('#name, #quantity, #is_active').on('input change', function() {
        updatePreview();
    });

    // Validasi quantity
    $('#quantity').on('input', function() {
        const value = parseInt($(this).val());
        if (value > 1000) {
            $(this).val(1000);
        } else if (value < 1) {
            $(this).val(1);
        }
    });

    // Form validation
    $('form').on('submit', function(e) {
        let isValid = true;

        // Validasi nama hadiah (minimal 3 karakter)
        const name = $('#name').val().trim();
        if (name.length < 3) {
            e.preventDefault();
            isValid = false;

            $('#name').addClass('is-invalid');
            $('#name').next('.invalid-feedback').remove();
            $('#name').after('<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>Nama hadiah harus minimal 3 karakter</div>');
        } else {
            $('#name').removeClass('is-invalid');
        }

        // Validasi quantity
        const quantity = parseInt($('#quantity').val());
        if (isNaN(quantity) || quantity < 1 || quantity > 1000) {
            e.preventDefault();
            isValid = false;

            $('#quantity').addClass('is-invalid');
            $('#quantity').next('.invalid-feedback').remove();
            $('#quantity').after('<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>Jumlah hadiah harus antara 1-1000</div>');
        } else {
            $('#quantity').removeClass('is-invalid');
        }

        // Show loading if valid
        if (isValid) {
            $(this).find('button[type="submit"]').html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...').prop('disabled', true);
        }
    });

    /**
     * Update preview hadiah
     */
    function updatePreview() {
        const name = $('#name').val().trim();
        const description = $('#description').val().trim();
        const quantity = $('#quantity').val();
        const isActive = $('#is_active').is(':checked');

        if (name.length > 0) {
            $('#prizePreview').show();
            $('#previewName').text(name || '-');
            $('#previewDescription').text(description || 'Tidak ada deskripsi');
            $('#previewQuantity').text(quantity + ' unit');

            if (isActive) {
                $('#previewStatus').removeClass('bg-danger').addClass('bg-success').text('Aktif');
            } else {
                $('#previewStatus').removeClass('bg-success').addClass('bg-danger').text('Nonaktif');
            }
        } else {
            $('#prizePreview').hide();
        }
    }
});
</script>

<style>
.avatar-lg {
    width: 64px;
    height: 64px;
}
</style>
@endsection
