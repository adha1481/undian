@extends('layouts.app')

@section('title', 'Daftar Peserta Undian')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="mb-2">
            <i class="fas fa-users text-primary me-2"></i>
            Daftar Peserta Undian
        </h1>
        <p class="text-muted mb-0">Kelola data peserta yang ikut dalam undian hadiah</p>
    </div>
    <a href="{{ route('participants.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        Tambah Peserta
    </a>
</div>

<!-- Statistik Peserta -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <i class="fas fa-users fa-2x mb-2"></i>
                <h4>{{ $participants->total() }}</h4>
                <p class="mb-0">Total Peserta</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <i class="fas fa-crown fa-2x mb-2"></i>
                <h4>{{ \App\Models\Participant::where('has_won', true)->count() }}</h4>
                <p class="mb-0">Sudah Menang</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <i class="fas fa-user-clock fa-2x mb-2"></i>
                <h4>{{ \App\Models\Participant::where('has_won', false)->count() }}</h4>
                <p class="mb-0">Belum Menang</p>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Peserta -->
<div class="card">
    <div class="card-body">
        @if($participants->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">#</th>
                            <th width="25%">Nama</th>
                            <th width="40%">Alamat</th>
                            <th width="10%">Status</th>
                            <th width="15%">Tanggal Daftar</th>
                            <th width="5%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($participants as $index => $participant)
                            <tr>
                                <td>{{ ($participants->currentPage() - 1) * $participants->perPage() + $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                        <div>
                                            <strong>{{ $participant->name }}</strong>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $participant->address }}</small>
                                </td>
                                <td>
                                    @if($participant->has_won)
                                        <span class="badge bg-success">
                                            <i class="fas fa-crown me-1"></i>Sudah Menang
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-clock me-1"></i>Belum Menang
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $participant->created_at->format('d/m/Y H:i') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('participants.show', $participant) }}">
                                                    <i class="fas fa-eye me-2"></i>Lihat Detail
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('participants.edit', $participant) }}">
                                                    <i class="fas fa-edit me-2"></i>Edit
                                                </a>
                                            </li>
                                            @if(!$participant->has_won)
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('participants.destroy', $participant) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('Yakin ingin menghapus peserta ini?')"
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
                {{ $participants->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-users fa-4x text-muted mb-3"></i>
                <h4>Belum Ada Peserta</h4>
                <p class="text-muted mb-4">Silakan tambahkan peserta pertama untuk memulai undian</p>
                <a href="{{ route('participants.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Tambah Peserta
                </a>
            </div>
        @endif
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
