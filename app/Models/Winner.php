<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Winner untuk mengelola data pemenang undian
 */
class Winner extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi mass assignment
     */
    protected $fillable = [
        'participant_id',
        'prize_id',
        'won_at'
    ];

    /**
     * Cast atribut ke tipe data yang sesuai
     */
    protected $casts = [
        'won_at' => 'datetime'
    ];

    /**
     * Relasi dengan model Participant
     * Setiap pemenang milik satu peserta
     */
    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }

    /**
     * Relasi dengan model Prize
     * Setiap pemenang memenangkan satu hadiah
     */
    public function prize()
    {
        return $this->belongsTo(Prize::class);
    }
}
