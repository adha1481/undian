@extends('layouts.app')

@section('title', 'Panen Hadiah Simpedes - BRI KC Jalan Juanda')

@section('content')
<div class="container-fluid">
    <!-- Header Panen Hadiah Simpedes -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-lg border-0 simpedes-header">
                <div class="card-body text-center text-white py-5 position-relative">
                    <!-- Floating elements background -->
                    <div class="floating-elements">
                        <div class="parachute parachute-1">🪂</div>
                        <div class="parachute parachute-2">🎁</div>
                        <div class="parachute parachute-3">🚗</div>
                        <div class="parachute parachute-4">🏍️</div>
                        <div class="floating-gift">💰</div>
                        <div class="floating-gift floating-gift-2">📱</div>
                    </div>

                    <div class="position-relative z-index-2">
                    <div class="d-flex justify-content-center align-items-center mb-3">
                            <div class="bri-logo-large me-4">
                                <i class="fas fa-university fa-4x"></i>
                            </div>
                        <div>
                                <h1 class="mb-0 fw-bold event-main-title">PANEN HADIAH</h1>
                                <h2 class="mb-0 fw-bold text-warning">SIMPEDES</h2>
                                <h4 class="mb-0 opacity-85">Periode Semester 2 2024</h4>
                        </div>
                    </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Lottery Display -->
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 mb-4 lottery-card">
                <div class="card-header simpedes-card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-dice me-2"></i>
                        Pengundian Hadiah Simpedes
                        <small class="float-end opacity-75">Sep 2024 - Feb 2025</small>
                    </h4>
                </div>
                <div class="card-body text-center py-5 lottery-body">
                    <!-- Prize Selection -->
                    <div class="mb-4">
                        <label for="prizeSelect" class="form-label fs-5 fw-bold text-bri-blue">
                            <i class="fas fa-gift me-2"></i>Pilih Hadiah:
                        </label>
                        <select id="prizeSelect" class="form-select form-select-lg mx-auto prize-select">
                            <option value="">-- Pilih Hadiah Simpedes --</option>
                            @foreach($prizes as $prize)
                                @if($prize->isAvailable())
                                    <option value="{{ $prize->id }}">
                                        {{ $prize->name }}
                                        ({{ $prize->quantity - $prize->winners_count }} unit tersisa)
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <!-- Participant Display -->
                    <div class="lottery-display mb-4 p-5 rounded-4 position-relative participant-display">
                        <div id="participantName" class="display-3 fw-bold text-bri-blue mb-3 participant-name-text">
                            <i class="fas fa-parachute-box me-3"></i>
                            Pilih hadiah untuk memulai undian
                        </div>
                        <div id="participantInfo" class="lead text-muted participant-info"></div>

                        <!-- Background decorations -->
                        <div class="position-absolute lottery-bg-decoration">
                            <div class="lottery-cloud lottery-cloud-1">☁️</div>
                            <div class="lottery-cloud lottery-cloud-2">☁️</div>
                            <div class="lottery-cloud lottery-cloud-3">☁️</div>
                        </div>
                    </div>

                    <!-- Control Buttons -->
                    <div class="d-flex justify-content-center gap-3 mb-4 control-buttons">
                        <button id="startBtn" class="btn btn-lg px-5 py-3 fw-bold btn-start-simpedes" disabled>
                            <i class="fas fa-play me-2"></i>MULAI UNDIAN SIMPEDES
                        </button>
                        <button id="stopBtn" class="btn btn-lg px-5 py-3 fw-bold btn-stop-simpedes" disabled>
                            <i class="fas fa-stop me-2"></i>STOP & PILIH PEMENANG
                        </button>
                    </div>

                    <!-- Live Animation Status -->
                    <div id="animationStatus" class="mb-4" style="display: none;">
                        <div class="alert alert-info border-0 shadow-sm">
                            <i class="fas fa-spinner fa-spin me-2"></i>
                            Sedang mengundi peserta Simpedes...
                            <strong class="text-bri-blue">Bersiaplah untuk panen hadiah!</strong>
                        </div>
                    </div>

                    <!-- Statistics Simpedes -->
                    <div class="row text-center simpedes-stats">
                        <div class="col-md-4">
                            <div class="stat-card stat-participants">
                                <i class="fas fa-users fa-2x text-bri-blue mb-2"></i>
                                <h4 class="fw-bold">{{ $totalParticipants }}</h4>
                                <small class="text-muted">Nasabah Simpedes</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-card stat-prizes">
                                <i class="fas fa-gift fa-2x text-warning mb-2"></i>
                                <h4 class="fw-bold">{{ $totalPrizes }}</h4>
                                <small class="text-muted">Total Hadiah</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-card stat-winners">
                                <i class="fas fa-trophy fa-2x text-success mb-2"></i>
                                <h4 class="fw-bold">{{ $totalWinners }}</h4>
                                <small class="text-muted">Pemenang Beruntung</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Control Panel -->
        <div class="col-lg-4">
            <!-- Winner Announcement -->
            <div id="winnerCard" class="card shadow-lg border-0 mb-4 winner-card" style="display: none;">
                <div class="card-body text-center text-white py-4 position-relative">
                    <!-- Confetti Animation -->
                    <div class="confetti-container"></div>
                    <div class="celebration-animation">
                        <i class="fas fa-trophy fa-4x mb-3 text-warning celebration-trophy"></i>
                        <div class="celebration-text">
                    <h3 class="fw-bold mb-2">🎉 SELAMAT! 🎉</h3>
                            <h4 class="fw-bold text-warning mb-2">PANEN HADIAH SIMPEDES!</h4>
                        </div>
                    </div>
                    <div id="winnerName" class="display-6 fw-bold mb-2 winner-name-display"></div>
                    <div id="winnerPrize" class="lead mb-3 winner-prize-display"></div>
                    <div id="winnerAddress" class="small opacity-75 winner-address-display"></div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-3 justify-content-center mt-4">
                        <button id="nextBtn" class="btn btn-light btn-lg fw-bold next-lottery-btn">
                            <i class="fas fa-forward me-2"></i>Undian Hadiah Selanjutnya
                        </button>
                        <button id="cancelBtn" class="btn btn-outline-danger btn-lg fw-bold cancel-winner-btn">
                            <i class="fas fa-times me-2"></i>Batal & Undian Ulang
                        </button>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow border-0 mb-4 control-panel-card">
                <div class="card-header simpedes-panel-header">
                    <h5 class="mb-0">
                        <i class="fas fa-cogs me-2"></i>Panel Kontrol Simpedes
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('participants.index') }}" class="btn btn-outline-primary btn-control">
                            <i class="fas fa-users me-2"></i>Kelola Nasabah Simpedes
                        </a>
                        <a href="{{ route('prizes.index') }}" class="btn btn-outline-warning btn-control">
                            <i class="fas fa-gift me-2"></i>Kelola Hadiah
                        </a>
                        <a href="{{ route('lottery.winners') }}" class="btn btn-outline-success btn-control">
                            <i class="fas fa-trophy me-2"></i>Daftar Pemenang
                        </a>
                        <button id="resetBtn" class="btn btn-outline-danger btn-control">
                            <i class="fas fa-redo me-2"></i>Reset Undian
                        </button>
                    </div>
                </div>
            </div>

            <!-- Recent Winners -->
            @if($recentWinners->count() > 0)
                <div class="card shadow border-0 recent-winners-card">
                    <div class="card-header simpedes-panel-header">
                        <h5 class="mb-0">
                            <i class="fas fa-star me-2"></i>Pemenang Terbaru
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @foreach($recentWinners->take(5) as $winner)
                                @if($winner->participant && $winner->prize)
                                    <div class="list-group-item winner-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                                <strong class="text-bri-blue">
                                                    <i class="fas fa-crown me-1 text-warning"></i>
                                                    {{ $winner->participant->name }}
                                                </strong>
                                            <br>
                                                <small class="text-muted">
                                                    <i class="fas fa-gift me-1"></i>
                                                    {{ $winner->prize->name }}
                                                </small>
                                        </div>
                                        <small class="text-muted">{{ $winner->won_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
:root {
    --bri-blue: #003d7a;
    --bri-light-blue: #0056b3;
    --bri-orange: #ff8c00;
    --bri-gold: #ffd700;
    --sky-blue: #87ceeb;
    --cloud-white: #f8f9fa;
}

/* Header Simpedes dengan animasi background */
.simpedes-header {
    background: linear-gradient(135deg, var(--bri-blue) 0%, var(--bri-light-blue) 50%, var(--sky-blue) 100%);
    position: relative;
    overflow: hidden;
}

.simpedes-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image:
        radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(255, 140, 0, 0.1) 0%, transparent 50%);
    animation: backgroundFloat 10s ease-in-out infinite alternate;
}

@keyframes backgroundFloat {
    0% { transform: translateX(0px) translateY(0px); }
    100% { transform: translateX(20px) translateY(-10px); }
}

/* Floating elements seperti parasut */
.floating-elements {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    overflow: hidden;
    pointer-events: none;
}

.parachute {
    position: absolute;
    font-size: 2rem;
    animation: parachuteFloat 8s ease-in-out infinite;
    opacity: 0.3;
}

.parachute-1 {
    top: 10%;
    left: 10%;
    animation-delay: 0s;
}

.parachute-2 {
    top: 20%;
    right: 15%;
    animation-delay: 2s;
}

.parachute-3 {
    top: 60%;
    left: 20%;
    animation-delay: 4s;
}

.parachute-4 {
    top: 70%;
    right: 25%;
    animation-delay: 6s;
}

.floating-gift {
    position: absolute;
    font-size: 1.5rem;
    animation: giftFloat 6s ease-in-out infinite;
    opacity: 0.2;
    top: 40%;
    left: 70%;
}

.floating-gift-2 {
    top: 30%;
    left: 80%;
    animation-delay: 3s;
}

@keyframes parachuteFloat {
    0%, 100% { transform: translateY(0px) translateX(0px) rotate(0deg); }
    25% { transform: translateY(-10px) translateX(5px) rotate(2deg); }
    50% { transform: translateY(-5px) translateX(-5px) rotate(-1deg); }
    75% { transform: translateY(-15px) translateX(10px) rotate(3deg); }
}

@keyframes giftFloat {
    0%, 100% { transform: translateY(0px) scale(1); }
    50% { transform: translateY(-15px) scale(1.1); }
}

/* Event title styling */
.event-main-title {
    font-size: 3.5rem;
    text-shadow: 3px 3px 6px rgba(0,0,0,0.3);
    letter-spacing: 2px;
}

.z-index-2 {
    z-index: 2;
}

/* Card headers */
.simpedes-card-header {
    background: linear-gradient(90deg, var(--bri-blue), var(--bri-light-blue));
    color: white;
    border-bottom: 3px solid var(--bri-orange);
}

.simpedes-panel-header {
    background: linear-gradient(90deg, var(--bri-orange), var(--bri-gold));
    color: white;
    border-bottom: 2px solid var(--bri-blue);
}

/* Lottery body */
.lottery-body {
    background: linear-gradient(135deg, #ffffff 0%, #f0f8ff 50%, #e6f3ff 100%);
}

/* Prize select */
.prize-select {
    max-width: 500px;
    border: 3px solid var(--bri-blue);
    border-radius: 15px;
    font-weight: 600;
    background: white;
}

.prize-select:focus {
    border-color: var(--bri-orange);
    box-shadow: 0 0 0 0.2rem rgba(255, 140, 0, 0.25);
}

/* Participant display */
.participant-display {
    background: linear-gradient(135deg, white 0%, #f8f9ff 100%);
    border: 4px solid var(--bri-blue);
    min-height: 280px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    position: relative;
    overflow: hidden;
}

.participant-name-text {
    color: var(--bri-blue) !important;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    transition: all 0.25s ease;
}

/* Background clouds */
.lottery-bg-decoration {
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: -1;
}

.lottery-cloud {
    position: absolute;
    font-size: 3rem;
    opacity: 0.1;
    animation: cloudFloat 12s ease-in-out infinite;
}

.lottery-cloud-1 {
    top: 20%;
    left: 10%;
    animation-delay: 0s;
}

.lottery-cloud-2 {
    top: 60%;
    right: 20%;
    animation-delay: 4s;
}

.lottery-cloud-3 {
    top: 80%;
    left: 70%;
    animation-delay: 8s;
}

@keyframes cloudFloat {
    0%, 100% { transform: translateX(0px); }
    50% { transform: translateX(20px); }
}

/* Control buttons */
.btn-start-simpedes {
    background: linear-gradient(45deg, #28a745, #20c997);
    border: none;
    color: white;
    border-radius: 25px;
    box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
    transition: all 0.3s ease;
}

.btn-start-simpedes:hover:not(:disabled) {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(40, 167, 69, 0.6);
}

.btn-stop-simpedes {
    background: linear-gradient(45deg, #dc3545, #c82333);
    border: none;
    color: white;
    border-radius: 25px;
    box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
    transition: all 0.3s ease;
}

.btn-stop-simpedes:hover:not(:disabled) {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(220, 53, 69, 0.6);
}

/* Statistics cards */
.simpedes-stats .stat-card {
    padding: 20px;
    border-radius: 15px;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.stat-participants {
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    border-color: var(--bri-light-blue);
}

.stat-prizes {
    background: linear-gradient(135deg, #fff3e0 0%, #ffcc02 100%);
    border-color: var(--bri-gold);
}

.stat-winners {
    background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%);
    border-color: #4caf50;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

/* Winner card */
.winner-card {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    animation: celebration 1s ease-in-out infinite alternate;
}

@keyframes celebration {
    0% { transform: scale(1) rotate(0deg); }
    100% { transform: scale(1.02) rotate(0.5deg); }
}

.celebration-trophy {
    animation: trophyBounce 1s ease-in-out infinite;
}

@keyframes trophyBounce {
    0%, 100% { transform: translateY(0px) scale(1); }
    50% { transform: translateY(-10px) scale(1.1); }
}

/* Control panel buttons */
.btn-control {
    border-width: 2px;
    border-radius: 12px;
    font-weight: 600;
    padding: 12px 20px;
    transition: all 0.3s ease;
}

.btn-control:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

/* Lottery active state */
.lottery-active {
    border-color: #28a745 !important;
    border-width: 5px !important;
    box-shadow: 0 0 40px rgba(40, 167, 69, 0.5);
    animation: pulse-border 1.5s infinite;
}

@keyframes pulse-border {
    0% { box-shadow: 0 0 40px rgba(40, 167, 69, 0.5); }
    50% { box-shadow: 0 0 40px rgba(40, 167, 69, 0.8); }
    100% { box-shadow: 0 0 40px rgba(40, 167, 69, 0.5); }
}

/* Participant name animation saat spinning */
.participant-name {
    animation: nameSpinSimpedes 0.25s ease-in-out;
}

@keyframes nameSpinSimpedes {
    0% {
        opacity: 0;
        transform: scale(0.8) rotate(-3deg) translateY(-20px);
    }
    50% {
        opacity: 1;
        transform: scale(1.15) rotate(2deg) translateY(-10px);
    }
    100% {
        opacity: 1;
        transform: scale(1) rotate(0deg) translateY(0px);
    }
}

/* Winner items */
.winner-item {
    border-left: 4px solid var(--bri-orange);
    transition: all 0.3s ease;
}

.winner-item:hover {
    background-color: #f8f9fa;
    transform: translateX(5px);
}

/* Text utilities */
.text-bri-blue {
    color: var(--bri-blue) !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .event-main-title {
        font-size: 2.5rem;
    }

    .control-buttons {
        flex-direction: column;
    }

    .control-buttons .btn {
        margin-bottom: 10px;
    }

    .floating-elements {
        display: none; /* Hide floating elements on mobile */
    }
}

/* Confetti animation */
.confetti-container {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    pointer-events: none;
    overflow: hidden;
}

.confetti {
    position: absolute;
    width: 10px;
    height: 10px;
    background: #ffd700;
    animation: confettiFall 3s linear infinite;
}

@keyframes confettiFall {
    0% {
        transform: translateY(-100vh) rotate(0deg);
        opacity: 1;
    }
    100% {
        transform: translateY(100vh) rotate(720deg);
        opacity: 0;
    }
}

/* Sembunyikan panel kontrol untuk tampilan audiens */
.audience-mode .control-panel-card,
.audience-mode .recent-winners-card {
    display: none !important;
}

/* Mode layar lebar untuk audiens */
.audience-mode .lottery-main {
    width: 100% !important;
    max-width: none !important;
}

/* Floating control toggle */
.control-toggle {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1050;
    background: var(--bri-blue);
    color: white;
    border: none;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    box-shadow: 0 4px 20px rgba(0, 61, 122, 0.3);
    transition: all 0.3s ease;
}

.control-toggle:hover {
    background: var(--bri-orange);
    transform: scale(1.1);
}
</style>
@endsection

@section('scripts')
<script>
console.log('🎯 Panen Hadiah Simpedes - Lottery Script Loading...');

// Global variables untuk sistem undian
let lotteryInterval;
let participants = [];
let currentIndex = 0;
let isRunning = false;
let audienceMode = false;
let currentWinner = null; // Menyimpan data pemenang terkini

// DOM Elements
const prizeSelect = document.getElementById('prizeSelect');
const startBtn = document.getElementById('startBtn');
const stopBtn = document.getElementById('stopBtn');
const participantName = document.getElementById('participantName');
const participantInfo = document.getElementById('participantInfo');
const winnerCard = document.getElementById('winnerCard');
const animationStatus = document.getElementById('animationStatus');
const resetBtn = document.getElementById('resetBtn');
const nextBtn = document.getElementById('nextBtn');
const cancelBtn = document.getElementById('cancelBtn');

// Initialize saat dokumen ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ DOM Content Loaded - Initializing Lottery...');
    initializeLottery();
});

/**
 * Inisialisasi sistem undian
 */
function initializeLottery() {
    console.log('🚀 Initializing Panen Hadiah Simpedes System...');

    // Setup event listeners
    setupEventListeners();

    // Cek mode audience dari URL parameter
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('audience') === 'true') {
        enableAudienceMode();
    }

    console.log('✅ Lottery system initialized successfully!');
}

/**
 * Setup semua event listeners
 */
function setupEventListeners() {
    // Prize selection change
    if (prizeSelect) {
        prizeSelect.addEventListener('change', handlePrizeSelection);
    }

    // Start lottery button
    if (startBtn) {
        startBtn.addEventListener('click', startLottery);
    }

    // Stop lottery button
    if (stopBtn) {
        stopBtn.addEventListener('click', stopLottery);
    }

    // Reset button
    if (resetBtn) {
        resetBtn.addEventListener('click', resetLottery);
    }

        // Next lottery button
    if (nextBtn) {
        nextBtn.addEventListener('click', nextLottery);
    }

    // Cancel winner button
    if (cancelBtn) {
        cancelBtn.addEventListener('click', cancelWinner);
    }

    console.log('📝 Event listeners attached successfully');
}

/**
 * Handle perubahan pilihan hadiah
 */
function handlePrizeSelection() {
    const prizeId = prizeSelect.value;
    console.log('🎁 Prize selected:', prizeId);

        if (prizeId) {
        // Reset UI
        resetLotteryDisplay();

        // Fetch participants untuk hadiah ini
        fetchParticipants(prizeId);
        } else {
        // Reset semua
            participants = [];
        updateParticipantDisplay('Pilih hadiah untuk memulai undian', '');
        disableStartButton();
    }
}

/**
 * Fetch participants yang tersedia
 */
function fetchParticipants(prizeId) {
    console.log('👥 Fetching participants for prize:', prizeId);

    fetch(`/lottery/participants/${prizeId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('✅ Participants fetched:', data.length);
            participants = data;

            if (participants.length > 0) {
                updateParticipantDisplay(
                    `🎯 ${participants.length} Nasabah Simpedes Siap Undian!`,
                    'Klik "MULAI UNDIAN SIMPEDES" untuk memulai'
                );
                enableStartButton();
            } else {
                updateParticipantDisplay(
                    '❌ Tidak Ada Peserta Tersedia',
                    'Semua nasabah sudah mendapat hadiah atau belum ada yang mendaftar'
                );
                disableStartButton();
            }
        })
        .catch(error => {
            console.error('❌ Error fetching participants:', error);
            updateParticipantDisplay(
                '⚠️ Gagal Memuat Data',
                'Silakan refresh halaman dan coba lagi'
            );
            disableStartButton();
        });
}

/**
 * Mulai undian Simpedes
 */
function startLottery() {
    console.log('🎬 Starting Panen Hadiah Simpedes lottery...');

        if (participants.length === 0) {
        showAlert('Silakan pilih hadiah terlebih dahulu!', 'warning');
            return;
        }

    // Setup undian
        isRunning = true;
        currentIndex = 0;

    // Update UI
        startBtn.disabled = true;
        stopBtn.disabled = false;
        prizeSelect.disabled = true;

    // Show animation status
    if (animationStatus) {
        animationStatus.style.display = 'block';
    }

    // Add active class ke lottery display
    const lotteryDisplay = document.querySelector('.participant-display');
    if (lotteryDisplay) {
        lotteryDisplay.classList.add('lottery-active');
    }

         // Start cycling animation (100ms untuk efek cepat yang menarik)
     lotteryInterval = setInterval(() => {
         const participant = participants[currentIndex];

         // Update nama dengan animasi
         if (participantName) {
             participantName.className = 'display-3 fw-bold text-bri-blue mb-3 participant-name';
             participantName.innerHTML = `
                 <i class="fas fa-parachute-box me-3"></i>
                 ${participant.name}
             `;
         }

         if (participantInfo) {
             participantInfo.textContent = participant.address;
         }

         // Next participant
         currentIndex = (currentIndex + 1) % participants.length;
     }, 100); // 100ms untuk kecepatan yang lebih menarik

    console.log('✅ Lottery started successfully!');
}

/**
 * Stop undian dan pilih pemenang
 */
function stopLottery() {
    console.log('🛑 Stopping lottery and selecting winner...');

    if (!isRunning) {
        return;
    }

    // Stop animation
        clearInterval(lotteryInterval);
        isRunning = false;

    // Update UI
        stopBtn.disabled = true;

    // Hide animation status
    if (animationStatus) {
        animationStatus.style.display = 'none';
    }

    // Remove active class
    const lotteryDisplay = document.querySelector('.participant-display');
    if (lotteryDisplay) {
        lotteryDisplay.classList.remove('lottery-active');
    }

    // Get selected participant (previous index)
    const winnerIndex = currentIndex === 0 ? participants.length - 1 : currentIndex - 1;
    const selectedParticipant = participants[winnerIndex];
    const prizeId = prizeSelect.value;

    console.log('🏆 Selected winner:', selectedParticipant.name);

    // Draw winner via API
    drawWinner(selectedParticipant.id, prizeId);
}

/**
 * Draw winner via API
 */
function drawWinner(participantId, prizeId) {
    console.log('🎲 Drawing winner via API...');

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('/lottery/draw', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                participant_id: participantId,
                prize_id: prizeId
            })
        })
        .then(response => response.json())
        .then(data => {
        console.log('🎉 Draw response:', data);

            if (data.success) {
            showWinner(data.participant, data.prize);
            createConfetti();
            } else {
            showAlert(`Error: ${data.message}`, 'danger');
            resetLotteryState();
            }
        })
        .catch(error => {
        console.error('❌ Draw error:', error);
        showAlert('Terjadi kesalahan saat undian. Silakan coba lagi.', 'danger');
        resetLotteryState();
    });
}

/**
 * Tampilkan pemenang
 */
function showWinner(participant, prize) {
    console.log('🎊 Showing winner:', participant.name);

    // Simpan data pemenang untuk keperluan pembatalan
    currentWinner = {
        participant: participant,
        prize: prize
    };

    // Hide lottery display
    const lotteryCard = document.querySelector('.lottery-card');
    if (lotteryCard) {
        lotteryCard.style.display = 'none';
    }

    // Update winner card
    document.getElementById('winnerName').textContent = participant.name;
    document.getElementById('winnerPrize').textContent = `🎁 ${prize.name}`;
    document.getElementById('winnerAddress').textContent = participant.address;

    // Show winner card with animation
    if (winnerCard) {
        winnerCard.style.display = 'block';
        winnerCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    // Play celebration sound (if available)
    playSuccessSound();
}

/**
 * Create confetti animation
 */
function createConfetti() {
    console.log('🎊 Creating confetti animation...');

    const confettiContainer = document.querySelector('.confetti-container');
    if (!confettiContainer) return;

    // Clear existing confetti
    confettiContainer.innerHTML = '';

    // Create multiple confetti pieces
    for (let i = 0; i < 50; i++) {
        setTimeout(() => {
            const confetti = document.createElement('div');
            confetti.className = 'confetti';
            confetti.style.left = Math.random() * 100 + '%';
            confetti.style.backgroundColor = getRandomColor();
            confetti.style.animationDelay = Math.random() * 3 + 's';
            confettiContainer.appendChild(confetti);

            // Remove after animation
            setTimeout(() => {
                if (confetti.parentNode) {
                    confetti.parentNode.removeChild(confetti);
                }
            }, 3000);
        }, i * 50);
    }
}

/**
 * Get random confetti color
 */
function getRandomColor() {
    const colors = ['#ffd700', '#ff8c00', '#ff6b6b', '#4ecdc4', '#45b7d1', '#96ceb4', '#feca57'];
    return colors[Math.floor(Math.random() * colors.length)];
}

/**
 * Reset lottery state
 */
function resetLotteryState() {
    isRunning = false;
    clearInterval(lotteryInterval);

    startBtn.disabled = true;
    stopBtn.disabled = true;
    prizeSelect.disabled = false;

    if (animationStatus) {
        animationStatus.style.display = 'none';
    }

    const lotteryDisplay = document.querySelector('.participant-display');
    if (lotteryDisplay) {
        lotteryDisplay.classList.remove('lottery-active');
    }
}

/**
 * Reset lottery untuk undian selanjutnya
 */
function resetLottery() {
    if (confirm('Yakin ingin mereset semua data undian? Semua pemenang akan dihapus.')) {
        console.log('🔄 Resetting lottery data...');

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('/lottery/reset', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert(data.message, 'success');
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                showAlert(data.message, 'danger');
            }
        })
        .catch(error => {
            console.error('❌ Reset error:', error);
            showAlert('Gagal mereset data', 'danger');
        });
    }
}

/**
 * Next lottery (reload page)
 */
function nextLottery() {
    console.log('➡️ Starting next lottery...');
    location.reload();
}

/**
 * Cancel winner dan kembali ke undian
 */
function cancelWinner() {
    if (!currentWinner) {
        showAlert('Tidak ada pemenang yang bisa dibatalkan', 'warning');
        return;
    }

    if (confirm(`Yakin ingin membatalkan kemenangan ${currentWinner.participant.name}?\n\nPeserta ini tidak akan ikut dalam undian selanjutnya.`)) {
        console.log('❌ Canceling winner:', currentWinner.participant.name);

        // Call API untuk membatalkan pemenang
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('/lottery/cancel-winner', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                participant_id: currentWinner.participant.id,
                prize_id: currentWinner.prize.id
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('✅ Cancel response:', data);

            if (data.success) {
                showAlert(`Kemenangan ${currentWinner.participant.name} telah dibatalkan. Peserta tidak akan ikut undian lagi.`, 'info');

                // Remove participant dari list
                participants = participants.filter(p => p.id !== currentWinner.participant.id);

                // Reset UI
                currentWinner = null;
                resetLotteryDisplay();

                // Update display jika masih ada peserta
                if (participants.length > 0) {
                    updateParticipantDisplay(
                        `🎯 ${participants.length} Nasabah Simpedes Siap Undian!`,
                        'Klik "MULAI UNDIAN SIMPEDES" untuk undian ulang'
                    );
                    enableStartButton();
                } else {
                    updateParticipantDisplay(
                        '❌ Tidak Ada Peserta Tersisa',
                        'Semua peserta sudah mendapat hadiah atau dibatalkan'
                    );
                    disableStartButton();
                }
            } else {
                showAlert(`Error: ${data.message}`, 'danger');
            }
        })
        .catch(error => {
            console.error('❌ Cancel error:', error);
            showAlert('Terjadi kesalahan saat membatalkan pemenang', 'danger');
        });
    }
}

/**
 * Update participant display
 */
function updateParticipantDisplay(name, info) {
    if (participantName) {
        participantName.innerHTML = name;
    }
    if (participantInfo) {
        participantInfo.textContent = info;
    }
}

/**
 * Enable start button
 */
function enableStartButton() {
    if (startBtn) {
        startBtn.disabled = false;
        startBtn.classList.add('btn-ready');
    }
}

/**
 * Disable start button
 */
function disableStartButton() {
    if (startBtn) {
        startBtn.disabled = true;
        startBtn.classList.remove('btn-ready');
    }
}

/**
 * Reset lottery display
 */
function resetLotteryDisplay() {
    resetLotteryState();

    const lotteryCard = document.querySelector('.lottery-card');
    if (lotteryCard) {
        lotteryCard.style.display = 'block';
    }

    if (winnerCard) {
        winnerCard.style.display = 'none';
    }
}

/**
 * Show alert message
 */
function showAlert(message, type = 'info') {
    // Create alert element
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        <i class="fas fa-info-circle me-2"></i>${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    // Insert at top of container
    const container = document.querySelector('.container-fluid');
    if (container) {
        container.insertBefore(alertDiv, container.firstChild);

        // Auto hide after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.classList.remove('show');
                setTimeout(() => {
                    if (alertDiv.parentNode) {
                        alertDiv.parentNode.removeChild(alertDiv);
                    }
                }, 150);
            }
        }, 5000);
    }
}

/**
 * Play success sound (if audio available)
 */
function playSuccessSound() {
    try {
        // Create audio context untuk success sound
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();

        oscillator.connect(gainNode);
        gainNode.connect(audioContext.destination);

        oscillator.frequency.setValueAtTime(587.33, audioContext.currentTime); // D5
        oscillator.frequency.setValueAtTime(783.99, audioContext.currentTime + 0.1); // G5
        oscillator.frequency.setValueAtTime(987.77, audioContext.currentTime + 0.2); // B5

        gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
        gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.5);

        oscillator.start(audioContext.currentTime);
        oscillator.stop(audioContext.currentTime + 0.5);
    } catch (error) {
        console.log('🔇 Audio not available');
    }
}

/**
 * Enable audience mode (hide control panels)
 */
function enableAudienceMode() {
    console.log('👥 Enabling audience mode...');

    document.body.classList.add('audience-mode');
    audienceMode = true;

    // Create floating toggle button
    createControlToggle();

    // Adjust layout for full screen
    const lotteryMain = document.querySelector('.col-lg-8');
    if (lotteryMain) {
        lotteryMain.className = 'col-12 lottery-main';
    }
}

/**
 * Create floating control toggle button
 */
function createControlToggle() {
    const toggleBtn = document.createElement('button');
    toggleBtn.className = 'control-toggle';
    toggleBtn.innerHTML = '<i class="fas fa-cog"></i>';
    toggleBtn.title = 'Toggle Control Panel';

    toggleBtn.addEventListener('click', () => {
        if (audienceMode) {
            document.body.classList.remove('audience-mode');
            toggleBtn.innerHTML = '<i class="fas fa-eye-slash"></i>';
            audienceMode = false;
        } else {
            document.body.classList.add('audience-mode');
            toggleBtn.innerHTML = '<i class="fas fa-cog"></i>';
            audienceMode = true;
        }
    });

    document.body.appendChild(toggleBtn);
}

// URL Parameters helper untuk audience mode
function toggleAudienceMode() {
    const url = new URL(window.location);
    const currentMode = url.searchParams.get('audience');

    if (currentMode === 'true') {
        url.searchParams.delete('audience');
} else {
        url.searchParams.set('audience', 'true');
}

    window.location.href = url.toString();
}

console.log('✅ Panen Hadiah Simpedes - Script Loaded Successfully! 🎉');
</script>
@endsection
