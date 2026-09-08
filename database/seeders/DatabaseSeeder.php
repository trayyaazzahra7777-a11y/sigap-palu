<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Panggil seeder yang baru kita buat agar dieksekusi secara berurutan
        $this->call([
            UserSeeder::class,
            WilayahSeeder::class,
            JenisBencanaSeeder::class,
            IndikatorSeeder::class,
            SumberDataSeeder::class,
            LayerGisSeeder::class,
            MonitoringSeeder::class,
            DataGempaSeeder::class,
            DataMukaLautSeeder::class,
        ]);
    }
}
