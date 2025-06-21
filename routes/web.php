<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\PrizeController;
use App\Http\Controllers\LotteryController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Routes untuk aplikasi undian hadiah dengan sistem autentikasi
| 1. Login/Logout admin dengan role-based access
| 2. CRUD peserta (Admin Peserta & Super Admin)
| 3. CRUD hadiah (Admin Hadiah & Super Admin)
| 4. Sistem undian (Admin Undian & Super Admin)
| 5. Halaman pemenang (Publik tanpa login)
|
*/

// Routes untuk Guest (tidak perlu login)
Route::middleware('guest')->group(function () {
    // Halaman login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Routes untuk pemenang - bisa diakses tanpa login
Route::get('/lottery/winners', [LotteryController::class, 'winners'])->name('lottery.winners');

// Route fallback untuk lottery - redirect ke winners untuk guest, ke admin lottery untuk admin
Route::get('/lottery', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->role === 'admin_undian' || $user->role === 'super_admin') {
            return redirect()->route('lottery.admin.index');
        }
    }
    return redirect()->route('lottery.winners');
})->name('lottery.index');

// Redirect root ke dashboard jika sudah login, ke pemenang jika belum
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('lottery.winners');
})->name('home');

// Routes untuk admin yang sudah login
Route::middleware('auth')->group(function () {

    // Dashboard dan profil - semua admin
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Routes untuk Admin Peserta dan Super Admin
    Route::middleware('role:admin_peserta,super_admin')->group(function () {
        Route::resource('participants', ParticipantController::class)->names([
            'index' => 'participants.index',
            'create' => 'participants.create',
            'store' => 'participants.store',
            'show' => 'participants.show',
            'edit' => 'participants.edit',
            'update' => 'participants.update',
            'destroy' => 'participants.destroy',
        ]);
    });

    // Routes untuk Admin Hadiah dan Super Admin
    Route::middleware('role:admin_hadiah,super_admin')->group(function () {
        Route::resource('prizes', PrizeController::class)->names([
            'index' => 'prizes.index',
            'create' => 'prizes.create',
            'store' => 'prizes.store',
            'show' => 'prizes.show',
            'edit' => 'prizes.edit',
            'update' => 'prizes.update',
            'destroy' => 'prizes.destroy',
        ]);
    });

    // Routes untuk Admin Undian dan Super Admin
    Route::middleware('role:admin_undian,super_admin')->group(function () {
        // Lottery admin routes dengan prefix
        Route::prefix('lottery/admin')->name('lottery.admin.')->group(function () {
            Route::get('/', [LotteryController::class, 'index'])->name('index');
            Route::get('/participants', [LotteryController::class, 'getParticipants'])->name('participants');
            Route::get('/prizes', [LotteryController::class, 'getPrizes'])->name('prizes');
            Route::post('/draw', [LotteryController::class, 'drawWinner'])->name('draw');
            Route::post('/reset', [LotteryController::class, 'reset'])->name('reset');
        });

        // Legacy lottery admin routes
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
    });
});
