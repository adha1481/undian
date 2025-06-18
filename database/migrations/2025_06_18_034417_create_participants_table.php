<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel peserta undian dengan kolom nama dan alamat
     */
    public function up(): void
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama peserta
            $table->text('address'); // Alamat peserta
            $table->boolean('has_won')->default(false); // Status apakah sudah pernah menang
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * Menghapus tabel peserta
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
