<?php

namespace App\Console\Commands;

use App\Services\BmkgIntegrationService;
use Illuminate\Console\Command;

class FetchBmkgGempa extends Command
{
    protected $signature = 'bmkg:fetch-gempa';
    protected $description = 'Menarik data gempa terbaru dari API Publik BMKG secara otomatis';

    public function handle(BmkgIntegrationService $bmkgService): int
    {
        $this->info('Memulai sinkronisasi data dari BMKG...');

        $result = $bmkgService->syncAllSources();

        if ($result['success']) {
            $this->info("Berhasil! {$result['total_new_earthquakes']} data gempa baru berhasil disinkronkan.");
            return Command::SUCCESS;
        }

        $this->error('Gagal mengambil data dari server BMKG: ' . ($result['errors'][0] ?? 'Koneksi gagal'));
        return Command::FAILURE;
    }
}