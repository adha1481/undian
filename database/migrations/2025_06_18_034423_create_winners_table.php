<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel pemenang untuk mencatat siapa yang menang hadiah apa
     */
    public function up(): void
    {
        Schema::create('winners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participant_id')->constrained('participants')->onDelete('cascade'); // ID peserta yang menang
            $table->foreignId('prize_id')->constrained('prizes')->onDelete('cascade'); // ID hadiah yang dimenangkan
            $table->timestamp('won_at'); // Tanggal dan waktu memenangkan hadiah
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * Menghapus tabel pemenang
     */
    public function down(): void
    {
        Schema::dropIfExists('winners');
    }
};
