<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds - Membuat admin users dengan berbagai role
     */
    public function run(): void
    {
        // Data admin dengan password yang sudah ditentukan
        $admins = [
            [
                'name' => 'Super Administrator',
                'email' => 'super@undian.com',
                'password' => 'SuperAdmin123!',
                'role' => User::ROLE_SUPER_ADMIN,
                'is_active' => true,
            ],
            [
                'name' => 'Admin Undian',
                'email' => 'undian@undian.com',
                'password' => 'AdminUndian123!',
                'role' => User::ROLE_ADMIN_UNDIAN,
                'is_active' => true,
            ],
            [
                'name' => 'Admin Peserta',
                'email' => 'peserta@undian.com',
                'password' => 'AdminPeserta123!',
                'role' => User::ROLE_ADMIN_PESERTA,
                'is_active' => true,
            ],
            [
                'name' => 'Admin Hadiah',
                'email' => 'hadiah@undian.com',
                'password' => 'AdminHadiah123!',
                'role' => User::ROLE_ADMIN_HADIAH,
                'is_active' => true,
            ],
        ];

        foreach ($admins as $admin) {
            // Cek apakah user sudah ada berdasarkan email
            $existingUser = User::where('email', $admin['email'])->first();

            if (!$existingUser) {
                User::create([
                    'name' => $admin['name'],
                    'email' => $admin['email'],
                    'password' => Hash::make($admin['password']),
                    'role' => $admin['role'],
                    'is_active' => $admin['is_active'],
                    'email_verified_at' => now(),
                ]);

                $this->command->info("✅ Admin {$admin['name']} berhasil dibuat!");
                $this->command->info("   📧 Email: {$admin['email']}");
                $this->command->info("   🔑 Password: {$admin['password']}");
                $this->command->info("   👤 Role: {$admin['role']}");
                $this->command->info("");
            } else {
                $this->command->warn("⚠️  Admin {$admin['name']} sudah ada!");
            }
        }

        $this->command->info("🎯 INFO LOGIN ADMIN:");
        $this->command->info("=====================");
        $this->command->info("🔐 SUPER ADMIN:");
        $this->command->info("   Email: super@undian.com");
        $this->command->info("   Password: SuperAdmin123!");
        $this->command->info("");
        $this->command->info("🎪 ADMIN UNDIAN:");
        $this->command->info("   Email: undian@undian.com");
        $this->command->info("   Password: AdminUndian123!");
        $this->command->info("");
        $this->command->info("👥 ADMIN PESERTA:");
        $this->command->info("   Email: peserta@undian.com");
        $this->command->info("   Password: AdminPeserta123!");
        $this->command->info("");
        $this->command->info("🏆 ADMIN HADIAH:");
        $this->command->info("   Email: hadiah@undian.com");
        $this->command->info("   Password: AdminHadiah123!");
        $this->command->info("");
        $this->command->info("📝 Catatan: Halaman pemenang bisa diakses tanpa login");
    }
}
