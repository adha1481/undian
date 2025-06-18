<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Participant untuk mengelola data peserta undian
 */
class Participant extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi mass assignment
     */
    protected $fillable = [
        'name',
        'address',
        'has_won'
    ];

    /**
     * Cast atribut ke tipe data yang sesuai
     */
    protected $casts = [
        'has_won' => 'boolean'
    ];

    /**
     * Relasi dengan model Winner
     * Satu peserta bisa memiliki satu kemenangan
     */
    public function winner()
    {
        return $this->hasOne(Winner::class);
    }

    /**
     * Relasi dengan Prize melalui Winner
     * Mendapatkan hadiah yang dimenangkan peserta
     */
    public function prize()
    {
        return $this->hasOneThrough(Prize::class, Winner::class, 'participant_id', 'id', 'id', 'prize_id');
    }

    /**
     * Scope untuk peserta yang belum pernah menang
     */
    public function scopeNotWon($query)
    {
        return $query->where('has_won', false);
    }
}
