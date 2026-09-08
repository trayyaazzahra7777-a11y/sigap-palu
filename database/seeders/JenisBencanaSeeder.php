<?php

namespace Database\Seeders;

use App\Models\JenisBencana;
use Illuminate\Database\Seeder;

class JenisBencanaSeeder extends Seeder
{
    public function run(): void
    {
        JenisBencana::updateOrCreate(
            ['nama_bencana' => 'Gempa Bumi'],
            ['deskripsi' => 'Guncangan bumi akibat pelepasan energi di zona Sesar Palu-Koro.']
        );

        JenisBencana::updateOrCreate(
            ['nama_bencana' => 'Tsunami'],
            ['deskripsi' => 'Gelombang air laut besar yang dipicu oleh gempa bumi tektonik dangkal atau longsoran bawah laut di Teluk Palu.']
        );
    }
}
