<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FixStoragePermission extends Command
{
    protected $signature = 'fix:storage-permission';
    protected $description = 'Perbaiki permission folder storage & cache agar bisa ditulis';

    public function handle()
    {
        $paths = [
            storage_path('framework/sessions'),
            storage_path('framework/views'),
            storage_path('framework/cache'),
            base_path('bootstrap/cache'),
        ];

        foreach ($paths as $path) {
            if (!File::exists($path)) {
                File::makeDirectory($path, 0775, true);
                $this->info("Created missing folder: $path");
            }

            try {
                File::chmod($path, 0775);
                $this->info("Updated permission: $path");
            } catch (\Throwable $e) {
                $this->error("Failed to change permission for $path: " . $e->getMessage());
            }
        }

        $this->info('✅ Permission storage & cache sudah diperbaiki.');
        return Command::SUCCESS;
    }
}
