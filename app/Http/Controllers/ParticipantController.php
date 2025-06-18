<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;

/**
 * Controller untuk mengelola peserta undian
 */
class ParticipantController extends Controller
{
    /**
     * Menampilkan daftar semua peserta
     */
    public function index()
    {
        $participants = Participant::orderBy('created_at', 'desc')->paginate(10);
        return view('participants.index', compact('participants'));
    }

    /**
     * Menampilkan form untuk pendaftaran peserta baru
     */
    public function create()
    {
        return view('participants.create');
    }

    /**
     * Menyimpan peserta baru ke database
     */
    public function store(Request $request)
    {
        // Validasi input data peserta
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:1000',
        ], [
            'name.required' => 'Nama peserta wajib diisi',
            'name.max' => 'Nama peserta maksimal 255 karakter',
            'address.required' => 'Unit peserta wajib diisi',
            'address.max' => 'Unit peserta maksimal 1000 karakter',
        ]);

        try {
            // Simpan data peserta baru
            Participant::create($validated);

            return redirect()->route('participants.index')
                ->with('success', 'Peserta berhasil didaftarkan!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat mendaftarkan peserta: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail peserta
     */
    public function show(Participant $participant)
    {
        return view('participants.show', compact('participant'));
    }

    /**
     * Menampilkan form edit peserta
     */
    public function edit(Participant $participant)
    {
        return view('participants.edit', compact('participant'));
    }

    /**
     * Mengupdate data peserta
     */
    public function update(Request $request, Participant $participant)
    {
        // Validasi input data peserta
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:1000',
        ], [
            'name.required' => 'Nama peserta wajib diisi',
            'name.max' => 'Nama peserta maksimal 255 karakter',
            'address.required' => 'Unit peserta wajib diisi',
            'address.max' => 'Unit peserta maksimal 1000 karakter',
        ]);

        try {
            // Update data peserta
            $participant->update($validated);

            return redirect()->route('participants.index')
                ->with('success', 'Data peserta berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data peserta: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus peserta dari database
     */
    public function destroy(Participant $participant)
    {
        try {
            // Cek apakah peserta sudah pernah menang
            if ($participant->has_won) {
                return back()->with('error', 'Peserta yang sudah pernah menang tidak dapat dihapus!');
            }

            $participant->delete();

            return redirect()->route('participants.index')
                ->with('success', 'Peserta berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus peserta: ' . $e->getMessage());
        }
    }
}
