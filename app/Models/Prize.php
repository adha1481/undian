<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Prize untuk mengelola data hadiah undian
 */
class Prize extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi mass assignment
     */
    protected $fillable = [
        'name',
        'quantity',
        'winners_count',
        'description',
        'is_active'
    ];

    /**
     * Cast atribut ke tipe data yang sesuai
     */
    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Relasi dengan model Winner
     * Satu hadiah bisa dimenangkan oleh banyak peserta
     */
    public function winners()
    {
        return $this->hasMany(Winner::class);
    }

    /**
     * Scope untuk hadiah yang masih aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk hadiah yang masih tersedia (belum habis)
     */
    public function scopeAvailable($query)
    {
        return $query->whereColumn('winners_count', '<', 'quantity');
    }

    /**
     * Cek apakah hadiah masih tersedia
     */
    public function isAvailable()
    {
        return $this->winners_count < $this->quantity;
    }
}
