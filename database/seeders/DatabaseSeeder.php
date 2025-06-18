<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Participant;
use App\Models\Prize;
use App\Models\Winner;
use Illuminate\Support\Facades\DB;

/**
 * Database Seeder untuk aplikasi undian hadiah
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        echo "Membersihkan data existing...\n";

        // Delete data in correct order to avoid foreign key constraint issues
        Winner::query()->delete();
        Participant::query()->delete();
        Prize::query()->delete();

        // Reset auto increment
        DB::statement('ALTER TABLE winners AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE participants AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE prizes AUTO_INCREMENT = 1');

        echo "Membuat data peserta...\n";

        // Buat peserta dengan nama Indonesia yang realistis
        $participants = [
            ['name' => 'Budi Santoso', 'address' => 'Jl. Sudirman No. 45, Jakarta Pusat'],
            ['name' => 'Siti Nurhaliza', 'address' => 'Jl. Gatot Subroto No. 123, Jakarta Selatan'],
            ['name' => 'Ahmad Fauzi', 'address' => 'Jl. Diponegoro No. 67, Bandung'],
            ['name' => 'Dewi Sartika', 'address' => 'Jl. Pahlawan No. 89, Surabaya'],
            ['name' => 'Rizky Pratama', 'address' => 'Jl. Merdeka No. 156, Medan'],
            ['name' => 'Maya Indira', 'address' => 'Jl. Asia Afrika No. 234, Bandung'],
            ['name' => 'Farid Rahman', 'address' => 'Jl. Pemuda No. 78, Semarang'],
            ['name' => 'Rina Kusumawati', 'address' => 'Jl. Veteran No. 190, Malang'],
            ['name' => 'Doni Setiawan', 'address' => 'Jl. Kartini No. 45, Solo'],
            ['name' => 'Lestari Wulandari', 'address' => 'Jl. Cut Nyak Dien No. 67, Yogyakarta'],
            ['name' => 'Bayu Saputra', 'address' => 'Jl. Ahmad Yani No. 123, Denpasar'],
            ['name' => 'Indah Permata', 'address' => 'Jl. Hayam Wuruk No. 89, Makassar'],
            ['name' => 'Wahyu Hidayat', 'address' => 'Jl. Gajah Mada No. 156, Palembang'],
            ['name' => 'Nurjannah', 'address' => 'Jl. Juanda No. 234, Banjarmasin'],
            ['name' => 'Teguh Prasetyo', 'address' => 'Jl. Panglima Sudirman No. 78, Balikpapan']
        ];

        foreach ($participants as $participant) {
            Participant::create($participant);
        }

        echo "Membuat data hadiah...\n";

        // Buat hadiah menarik untuk undian BRI
        $prizes = [
            [
                'name' => 'iPhone 15 Pro Max 256GB',
                'description' => 'Smartphone flagship Apple terbaru dengan teknologi ProMax',
                'quantity' => 1,
                'is_active' => true
            ],
            [
                'name' => 'Gaming Laptop ASUS ROG Strix',
                'description' => 'Laptop gaming high-performance dengan RTX 4060',
                'quantity' => 1,
                'is_active' => true
            ],
            [
                'name' => 'Samsung Galaxy S24 Ultra',
                'description' => 'Flagship Android dengan S Pen dan kamera 200MP',
                'quantity' => 2,
                'is_active' => true
            ],
            [
                'name' => 'iPad Air 5th Gen 256GB',
                'description' => 'Tablet premium Apple dengan M1 chip',
                'quantity' => 2,
                'is_active' => true
            ],
            [
                'name' => 'Nintendo Switch OLED',
                'description' => 'Konsol gaming hybrid dengan layar OLED 7 inch',
                'quantity' => 3,
                'is_active' => true
            ],
            [
                'name' => 'Voucher Belanja Indomaret Rp 1.000.000',
                'description' => 'Voucher belanja untuk kebutuhan sehari-hari',
                'quantity' => 5,
                'is_active' => true
            ],
            [
                'name' => 'Smart TV LED 43 inch Samsung',
                'description' => 'TV pintar dengan koneksi WiFi dan aplikasi streaming',
                'quantity' => 2,
                'is_active' => true
            ],
            [
                'name' => 'Air Fryer Philips HD9650',
                'description' => 'Penggorengan tanpa minyak kapasitas 6.2L',
                'quantity' => 4,
                'is_active' => true
            ],
            [
                'name' => 'Voucher Grab Food Rp 500.000',
                'description' => 'Voucher makanan untuk delivery makanan favorit',
                'quantity' => 10,
                'is_active' => true
            ],
            [
                'name' => 'Sepeda Lipat Polygon Urbano',
                'description' => 'Sepeda lipat praktis untuk mobilitas urban',
                'quantity' => 3,
                'is_active' => true
            ]
        ];

        foreach ($prizes as $prize) {
            Prize::create($prize);
        }

        echo "Seeder berhasil dijalankan!\n";
        echo "- " . count($participants) . " peserta berhasil dibuat\n";
        echo "- " . count($prizes) . " hadiah berhasil dibuat\n";
        echo "- Total " . array_sum(array_column($prizes, 'quantity')) . " unit hadiah tersedia\n";
    }
}
