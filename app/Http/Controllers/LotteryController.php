<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Prize;
use App\Models\Winner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Controller untuk mengelola sistem undian
 */
class LotteryController extends Controller
{
    /**
     * Halaman utama undian
     */
    public function index()
    {
        $prizes = Prize::active()->available()->get();
        $totalParticipants = Participant::count();
        $totalPrizes = Prize::sum('quantity');
        $totalWinners = Winner::count();

        // Perbaikan query untuk recent winners dengan proper eager loading
        $recentWinners = Winner::with(['participant', 'prize'])
            ->whereHas('participant')
            ->whereHas('prize')
            ->latest('won_at')
            ->limit(5)
            ->get();

        return view('lottery.index', compact(
            'prizes',
            'totalParticipants',
            'totalPrizes',
            'totalWinners',
            'recentWinners'
        ));
    }

    /**
     * API untuk mendapatkan data peserta yang tersedia untuk undian
     */
    public function getParticipants()
    {
        $participants = Participant::notWon()
            ->select('id', 'name')
            ->get();

        return response()->json($participants);
    }

    /**
     * API untuk mendapatkan data hadiah yang tersedia
     */
    public function getPrizes()
    {
        $prizes = Prize::active()
            ->available()
            ->select('id', 'name', 'quantity', 'winners_count', 'description')
            ->get()
            ->map(function ($prize) {
                $prize->remaining = $prize->quantity - $prize->winners_count;
                return $prize;
            });

        return response()->json($prizes);
    }

    /**
     * Melakukan undian dan menentukan pemenang
     */
    public function drawWinner(Request $request)
    {
        // Validasi input
        $request->validate([
            'prize_id' => 'required|exists:prizes,id',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $prizeId = $request->prize_id;

                // Ambil hadiah yang dipilih
                $prize = Prize::find($prizeId);

                // Cek apakah hadiah masih tersedia
                if (!$prize || !$prize->is_active || !$prize->isAvailable()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Hadiah tidak tersedia atau sudah habis'
                    ], 400);
                }

                // Ambil peserta yang belum pernah menang
                $availableParticipants = Participant::notWon()->get();

                if ($availableParticipants->isEmpty()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Tidak ada peserta yang tersedia untuk undian'
                    ], 400);
                }

                // Pilih pemenang secara acak
                $winner = $availableParticipants->random();

                // Simpan data pemenang
                Winner::create([
                    'participant_id' => $winner->id,
                    'prize_id' => $prize->id,
                    'won_at' => now(),
                ]);

                // Update status peserta menjadi sudah menang
                $winner->update(['has_won' => true]);

                // Update jumlah pemenang hadiah
                $prize->increment('winners_count');

                // Load relasi untuk response
                $winner->load('prize');

                return response()->json([
                    'success' => true,
                    'message' => 'Selamat! Pemenang berhasil ditentukan',
                    'participant' => [
                        'id' => $winner->id,
                        'name' => $winner->name,
                        'address' => $winner->address,
                    ],
                    'prize' => [
                        'id' => $prize->id,
                        'name' => $prize->name,
                        'description' => $prize->description,
                    ]
                ]);
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat melakukan undian: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menampilkan daftar semua pemenang
     */
    public function winners()
    {
        $winners = Winner::with(['participant', 'prize'])
            ->orderBy('won_at', 'desc')
            ->paginate(20);

        return view('lottery.winners', compact('winners'));
    }

    /**
     * Mereset semua data undian (untuk testing/demo)
     */
    public function reset(Request $request)
    {
        try {
            return DB::transaction(function () {
                // Reset status peserta
                Participant::query()->update(['has_won' => false]);

                // Reset counter pemenang hadiah
                Prize::query()->update(['winners_count' => 0]);

                // Hapus semua data pemenang
                Winner::query()->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Data undian berhasil direset'
                ]);
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mereset data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API untuk mengambil peserta berdasarkan hadiah
     */
    public function getParticipantsByPrize($prizeId)
    {
        $participants = Participant::notWon()->get();
        return response()->json($participants);
    }

    /**
     * Membatalkan pemenang dan mengembalikan hadiah
     */
    public function cancelWinner(Request $request)
    {
        // Validasi input
        $request->validate([
            'participant_id' => 'required|exists:participants,id',
            'prize_id' => 'required|exists:prizes,id',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $participantId = $request->participant_id;
                $prizeId = $request->prize_id;

                // Cari data pemenang
                $winner = Winner::where('participant_id', $participantId)
                    ->where('prize_id', $prizeId)
                    ->first();

                if (!$winner) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Data pemenang tidak ditemukan'
                    ], 404);
                }

                // Ambil data peserta dan hadiah
                $participant = Participant::find($participantId);
                $prize = Prize::find($prizeId);

                if (!$participant || !$prize) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Data peserta atau hadiah tidak ditemukan'
                    ], 404);
                }

                // Hapus data pemenang
                $winner->delete();

                // Set peserta tidak bisa ikut undian lagi (tetap has_won = true tapi tidak akan muncul di list)
                // Ini akan memastikan peserta tidak muncul lagi dalam undian selanjutnya
                $participant->update(['has_won' => true]);

                // Kurangi counter pemenang hadiah
                $prize->decrement('winners_count');

                return response()->json([
                    'success' => true,
                    'message' => "Kemenangan {$participant->name} telah dibatalkan. Peserta tidak akan ikut undian lagi."
                ]);
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat membatalkan pemenang: ' . $e->getMessage()
            ], 500);
        }
    }
}
