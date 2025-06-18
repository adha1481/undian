@extends('layouts.app')

@section('title', 'Daftar Pemenang Undian')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="mb-2">
            <i class="fas fa-crown text-warning me-2"></i>
            Daftar Pemenang Undian
        </h1>
        <p class="text-muted mb-0">Selamat kepada para pemenang undian hadiah!</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('lottery.index') }}" class="btn btn-primary">
            <i class="fas fa-dice me-2"></i>
            Undian Baru
        </a>
        <a href="{{ route('participants.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-users me-2"></i>
            Lihat Peserta
        </a>
    </div>
</div>

<!-- Statistik Pemenang -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <i class="fas fa-crown fa-2x mb-2"></i>
                <h4>{{ $winners->total() }}</h4>
                <p class="mb-0">Total Pemenang</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <i class="fas fa-trophy fa-2x mb-2"></i>
                <h4>{{ \App\Models\Prize::where('winners_count', '>', 0)->count() }}</h4>
                <p class="mb-0">Hadiah Terundi</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <i class="fas fa-gift fa-2x mb-2"></i>
                <h4>{{ \App\Models\Prize::sum('winners_count') }}</h4>
                <p class="mb-0">Hadiah Terbagi</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <i class="fas fa-percentage fa-2x mb-2"></i>
                <h4>{{ \App\Models\Participant::count() > 0 ? number_format((\App\Models\Participant::where('has_won', true)->count() / \App\Models\Participant::count()) * 100, 1) : 0 }}%</h4>
                <p class="mb-0">Tingkat Kemenangan</p>
            </div>
        </div>
    </div>
</div>

<!-- Daftar Pemenang -->
<div class="card">
    <div class="card-body">
        @if($winners->count() > 0)
            <div class="row">
                @foreach($winners as $index => $winner)
                    <div class="col-lg-6 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <!-- Ranking Badge -->
                                    <div class="flex-shrink-0 me-3">
                                        @php
                                            $rank = ($winners->currentPage() - 1) * $winners->perPage() + $index + 1;
                                            $badgeClass = $rank <= 3 ? 'bg-warning' : 'bg-secondary';
                                            $icon = $rank == 1 ? 'fas fa-trophy' : ($rank == 2 ? 'fas fa-medal' : ($rank == 3 ? 'fas fa-award' : 'fas fa-star'));
                                        @endphp
                                        <div class="badge {{ $badgeClass }} rounded-circle p-3">
                                            <i class="{{ $icon }} fa-lg text-white"></i>
                                        </div>
                                        <div class="text-center mt-1">
                                            <small class="text-muted">#{{ $rank }}</small>
                                        </div>
                                    </div>

                                    <!-- Winner Info -->
                                    <div class="flex-grow-1">
                                        <h5 class="card-title mb-2">
                                            <i class="fas fa-user text-primary me-1"></i>
                                            {{ $winner->participant->name }}
                                        </h5>

                                        <div class="mb-2">
                                            <h6 class="text-success mb-1">
                                                <i class="fas fa-gift me-1"></i>
                                                {{ $winner->prize->name }}
                                            </h6>
                                            @if($winner->prize->description)
                                                <small class="text-muted">
                                                    {{ Str::limit($winner->prize->description, 80) }}
                                                </small>
                                            @endif
                                        </div>

                                        <div class="mb-2">
                                            <small class="text-muted">
                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                {{ Str::limit($winner->participant->address, 50) }}
                                            </small>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ $winner->won_at->format('d M Y, H:i') }}
                                            </small>
                                            <small class="text-success">
                                                <i class="fas fa-clock me-1"></i>
                                                {{ $winner->won_at->diffForHumans() }}
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Konfetti Effect untuk Top 3 -->
                                @if($rank <= 3)
                                    <div class="position-absolute top-0 end-0 p-2">
                                        <span class="text-warning">
                                            @if($rank == 1) 🏆 @elseif($rank == 2) 🥈 @else 🥉 @endif
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $winners->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-crown fa-4x text-muted mb-3"></i>
                <h4>Belum Ada Pemenang</h4>
                <p class="text-muted mb-4">Belum ada yang memenangkan undian. Mari mulai undian pertama!</p>
                <a href="{{ route('lottery.index') }}" class="btn btn-primary">
                    <i class="fas fa-dice me-2"></i>
                    Mulai Undian
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Hall of Fame untuk Top Winners -->
@if($winners->total() > 0)
    <div class="row mt-5">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="fas fa-star me-2"></i>
                        Hall of Fame
                    </h5>
                    <div class="row text-center">
                        @php
                            $topWinners = $winners->take(3);
                        @endphp
                        @foreach($topWinners as $index => $topWinner)
                            <div class="col-md-4">
                                <div class="mb-3">
                                    @if($index == 0)
                                        <i class="fas fa-trophy fa-3x text-warning mb-2"></i>
                                    @elseif($index == 1)
                                        <i class="fas fa-medal fa-3x text-light mb-2"></i>
                                    @else
                                        <i class="fas fa-award fa-3x text-info mb-2"></i>
                                    @endif
                                    <h6 class="fw-bold">{{ $topWinner->participant->name }}</h6>
                                    <small>{{ $topWinner->prize->name }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection

@section('styles')
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
}

.badge {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
@endsection
