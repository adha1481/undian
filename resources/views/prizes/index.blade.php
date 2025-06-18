@extends('layouts.app')

@section('title', 'Daftar Hadiah Undian')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="mb-2">
            <i class="fas fa-trophy text-primary me-2"></i>
            Daftar Hadiah Undian
        </h1>
        <p class="text-muted mb-0">Kelola hadiah yang tersedia untuk undian</p>
    </div>
    <a href="{{ route('prizes.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        Tambah Hadiah
    </a>
</div>

<!-- Statistik Hadiah -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <i class="fas fa-trophy fa-2x mb-2"></i>
                <h4>{{ $prizes->total() }}</h4>
                <p class="mb-0">Total Hadiah</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <i class="fas fa-check-circle fa-2x mb-2"></i>
                <h4>{{ \App\Models\Prize::active()->count() }}</h4>
                <p class="mb-0">Hadiah Aktif</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <i class="fas fa-gift fa-2x mb-2"></i>
                <h4>{{ \App\Models\Prize::sum('quantity') }}</h4>
                <p class="mb-0">Total Kuantitas</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <i class="fas fa-crown fa-2x mb-2"></i>
                <h4>{{ \App\Models\Prize::sum('winners_count') }}</h4>
                <p class="mb-0">Sudah Dimenangkan</p>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Hadiah -->
<div class="card">
    <div class="card-body">
        @if($prizes->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">#</th>
                            <th width="25%">Nama Hadiah</th>
                            <th width="30%">Deskripsi</th>
                            <th width="10%">Jumlah</th>
                            <th width="10%">Pemenang</th>
                            <th width="10%">Status</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prizes as $index => $prize)
                            <tr>
                                <td>{{ ($prizes->currentPage() - 1) * $prizes->perPage() + $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-warning rounded-circle d-flex align-items-center justify-content-center me-2">
                                            <i class="fas fa-gift text-white"></i>
                                        </div>
                                        <div>
                                            <strong>{{ $prize->name }}</strong>
                                            <br>
                                            <small class="text-muted">ID: #{{ str_pad($prize->id, 3, '0', STR_PAD_LEFT) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($prize->description)
                                        <small class="text-muted">{{ Str::limit($prize->description, 100) }}</small>
                                    @else
                                        <small class="text-muted fst-italic">Tidak ada deskripsi</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark fs-6">
                                        {{ $prize->quantity }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-{{ $prize->winners_count > 0 ? 'success' : 'secondary' }} me-1">
                                            {{ $prize->winners_count }}
                                        </span>
                                        @if($prize->quantity > 0)
                                            <small class="text-muted">
                                                ({{ number_format(($prize->winners_count / $prize->quantity) * 100, 1) }}%)
                                            </small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column gap-1">
                                        @if($prize->is_active)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>Aktif
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times me-1"></i>Nonaktif
                                            </span>
                                        @endif

                                        @if($prize->isAvailable())
                                            <span class="badge bg-primary">
                                                <i class="fas fa-box-open me-1"></i>Tersedia
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-box me-1"></i>Habis
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('prizes.show', $prize) }}">
                                                    <i class="fas fa-eye me-2"></i>Lihat Detail
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('prizes.edit', $prize) }}">
                                                    <i class="fas fa-edit me-2"></i>Edit
                                                </a>
                                            </li>
                                            @if($prize->winners_count == 0)
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('prizes.destroy', $prize) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('Yakin ingin menghapus hadiah ini?')"
                                                          style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="fas fa-trash me-2"></i>Hapus
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $prizes->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-trophy fa-4x text-muted mb-3"></i>
                <h4>Belum Ada Hadiah</h4>
                <p class="text-muted mb-4">Silakan tambahkan hadiah untuk memulai undian</p>
                <a href="{{ route('prizes.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Tambah Hadiah
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Legend -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card bg-light">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="fas fa-info-circle me-1"></i>
                    Keterangan Status:
                </h6>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-unstyled mb-0">
                            <li><span class="badge bg-success me-2">Aktif</span> - Hadiah dapat digunakan dalam undian</li>
                            <li><span class="badge bg-danger me-2">Nonaktif</span> - Hadiah tidak dapat digunakan dalam undian</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-unstyled mb-0">
                            <li><span class="badge bg-primary me-2">Tersedia</span> - Masih ada sisa hadiah untuk diundi</li>
                            <li><span class="badge bg-warning me-2">Habis</span> - Semua hadiah sudah dimenangkan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.avatar-sm {
    width: 32px;
    height: 32px;
    font-size: 0.8rem;
}
</style>
@endsection
