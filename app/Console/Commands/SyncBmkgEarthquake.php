<?php

namespace App\Console\Commands;

use App\Services\BmkgIntegrationService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('sigap:sync-bmkg {--all : Simpan seluruh data gempa nasional tanpa filter radius Palu}')]
#[Description('Sinkronisasi data gempabumi terbuka dari endpoint resmi BMKG')]
class SyncBmkgEarthquake extends Command
{
    public function handle(BmkgIntegrationService $bmkgService): int
    {
        $this->info('Memulai sinkronisasi data gempa resmi BMKG...');

        $result = $bmkgService->syncEarthquakes();

        if ($result['success']) {
            $this->info($result['message']);

            return Command::SUCCESS;
        }

        $this->error($result['message']);

        return Command::FAILURE;
    }
}
