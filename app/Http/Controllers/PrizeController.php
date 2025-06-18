<?php

namespace App\Http\Controllers;

use App\Models\Prize;
use Illuminate\Http\Request;

/**
 * Controller untuk mengelola hadiah undian
 */
class PrizeController extends Controller
{
    /**
     * Menampilkan daftar semua hadiah
     */
    public function index()
    {
        $prizes = Prize::orderBy('created_at', 'desc')->paginate(10);
        return view('prizes.index', compact('prizes'));
    }

    /**
     * Menampilkan form untuk menambah hadiah baru
     */
    public function create()
    {
        return view('prizes.create');
    }

    /**
     * Menyimpan hadiah baru ke database
     */
    public function store(Request $request)
    {
        // Validasi input data hadiah
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'Nama hadiah wajib diisi',
            'name.max' => 'Nama hadiah maksimal 255 karakter',
            'quantity.required' => 'Jumlah hadiah wajib diisi',
            'quantity.integer' => 'Jumlah hadiah harus berupa angka',
            'quantity.min' => 'Jumlah hadiah minimal 1',
            'description.max' => 'Deskripsi hadiah maksimal 1000 karakter',
        ]);

        try {
            // Set default value untuk is_active jika tidak ada
            $validated['is_active'] = $request->has('is_active');

            // Simpan data hadiah baru
            Prize::create($validated);

            return redirect()->route('prizes.index')
                ->with('success', 'Hadiah berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat menambahkan hadiah: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail hadiah
     */
    public function show(Prize $prize)
    {
        $prize->load('winners.participant'); // Load relasi pemenang
        return view('prizes.show', compact('prize'));
    }

    /**
     * Menampilkan form edit hadiah
     */
    public function edit(Prize $prize)
    {
        return view('prizes.edit', compact('prize'));
    }

    /**
     * Mengupdate data hadiah
     */
    public function update(Request $request, Prize $prize)
    {
        // Validasi input data hadiah
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:' . $prize->winners_count, // Minimal sesuai jumlah pemenang saat ini
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'Nama hadiah wajib diisi',
            'name.max' => 'Nama hadiah maksimal 255 karakter',
            'quantity.required' => 'Jumlah hadiah wajib diisi',
            'quantity.integer' => 'Jumlah hadiah harus berupa angka',
            'quantity.min' => 'Jumlah hadiah tidak boleh kurang dari jumlah pemenang yang sudah ada (' . $prize->winners_count . ')',
            'description.max' => 'Deskripsi hadiah maksimal 1000 karakter',
        ]);

        try {
            // Set default value untuk is_active jika tidak ada
            $validated['is_active'] = $request->has('is_active');

            // Update data hadiah
            $prize->update($validated);

            return redirect()->route('prizes.index')
                ->with('success', 'Data hadiah berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data hadiah: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus hadiah dari database
     */
    public function destroy(Prize $prize)
    {
        try {
            // Cek apakah hadiah sudah memiliki pemenang
            if ($prize->winners_count > 0) {
                return back()->with('error', 'Hadiah yang sudah memiliki pemenang tidak dapat dihapus!');
            }

            $prize->delete();

            return redirect()->route('prizes.index')
                ->with('success', 'Hadiah berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus hadiah: ' . $e->getMessage());
        }
    }
}
