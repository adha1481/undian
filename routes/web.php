<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\PrizeController;
use App\Http\Controllers\LotteryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Routes untuk aplikasi undian hadiah
| 1. Pendaftaran peserta
| 2. CRUD hadiah
| 3. Sistem undian dengan animasi
|
*/

// Redirect root to lottery page
Route::get('/', function () {
    return redirect()->route('lottery.index');
});

// Routes untuk mengelola peserta undian
Route::resource('participants', ParticipantController::class)->names([
    'index' => 'participants.index',
    'create' => 'participants.create',
    'store' => 'participants.store',
    'show' => 'participants.show',
    'edit' => 'participants.edit',
    'update' => 'participants.update',
    'destroy' => 'participants.destroy',
]);

// Routes untuk mengelola hadiah undian
Route::resource('prizes', PrizeController::class)->names([
    'index' => 'prizes.index',
    'create' => 'prizes.create',
    'store' => 'prizes.store',
    'show' => 'prizes.show',
    'edit' => 'prizes.edit',
    'update' => 'prizes.update',
    'destroy' => 'prizes.destroy',
]);

// Routes untuk sistem undian
Route::prefix('lottery')->name('lottery.')->group(function () {
    // Halaman utama undian
    Route::get('/', [LotteryController::class, 'index'])->name('index');

    // Halaman daftar pemenang
    Route::get('/winners', [LotteryController::class, 'winners'])->name('winners');

    // API routes untuk undian
    Route::get('/api/participants', [LotteryController::class, 'getParticipants'])->name('api.participants');
    Route::get('/api/prizes', [LotteryController::class, 'getPrizes'])->name('api.prizes');
    Route::post('/api/draw', [LotteryController::class, 'drawWinner'])->name('api.draw');
    Route::post('/api/reset', [LotteryController::class, 'reset'])->name('api.reset');
});

// Lottery Routes
Route::get('/lottery', [LotteryController::class, 'index'])->name('lottery.index');
Route::get('/lottery/winners', [LotteryController::class, 'winners'])->name('lottery.winners');
Route::get('/lottery/participants/{prize}', [LotteryController::class, 'getParticipantsByPrize']);
Route::post('/lottery/draw', [LotteryController::class, 'drawWinner']);
Route::post('/lottery/cancel-winner', [LotteryController::class, 'cancelWinner']);
Route::post('/lottery/reset', [LotteryController::class, 'reset']);

// API Routes (legacy - keep for compatibility)
Route::prefix('lottery/api')->name('lottery.api.')->group(function () {
    Route::get('/participants', [LotteryController::class, 'getParticipants'])->name('participants');
    Route::get('/prizes', [LotteryController::class, 'getPrizes'])->name('prizes');
    Route::post('/draw', [LotteryController::class, 'drawWinner'])->name('draw');
    Route::post('/reset', [LotteryController::class, 'reset'])->name('reset');
});
