<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations - Menambahkan kolom role untuk sistem admin
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom role dengan enum untuk berbagai level admin
            $table->enum('role', [
                'super_admin',      // Super Admin - akses penuh ke semua fitur
                'admin_undian',     // Admin Undian - hanya mengelola undian
                'admin_peserta',    // Admin Peserta - hanya mengelola peserta
                'admin_hadiah'      // Admin Hadiah - hanya mengelola hadiah
            ])->default('admin_peserta')->after('password');

            // Status aktif untuk admin
            $table->boolean('is_active')->default(true)->after('role');
        });
    }

    /**
     * Reverse the migrations - Menghapus kolom role
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'is_active']);
        });
    }
};
