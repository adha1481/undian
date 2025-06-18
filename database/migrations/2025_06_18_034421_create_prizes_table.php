<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel hadiah dengan nama barang, jumlah, dan status pemenang
     */
    public function up(): void
    {
        Schema::create('prizes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama hadiah/barang
            $table->integer('quantity'); // Jumlah hadiah yang tersedia
            $table->integer('winners_count')->default(0); // Jumlah pemenang saat ini
            $table->text('description')->nullable(); // Deskripsi hadiah
            $table->boolean('is_active')->default(true); // Status aktif hadiah
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * Menghapus tabel hadiah
     */
    public function down(): void
    {
        Schema::dropIfExists('prizes');
    }
};
