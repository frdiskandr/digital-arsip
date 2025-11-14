<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Arsip;
use Illuminate\Support\Facades\Storage;

class PurgeOldTrashedArsip extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'arsip:purge-old-trash {--days=365 : Number of days to keep trashed items}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hard delete (forceDelete) arsip yang berada di trash lebih lama dari jumlah hari tertentu (default 365).';

    public function handle()
    {
        $days = (int) $this->option('days');

        $threshold = now()->subDays($days);

        $this->info("Mencari arsip yang di-trash sebelum: {$threshold}");

        $deleted = 0;

        Arsip::onlyTrashed()
            ->where('deleted_at', '<=', $threshold)
            ->chunkById(100, function ($items) use (&$deleted) {
                foreach ($items as $item) {
                    // Delete physical file if exists. Use 'local' disk which is the project's default for uploads.
                    try {
                        if ($item->file_path && Storage::disk('local')->exists($item->file_path)) {
                            Storage::disk('local')->delete($item->file_path);
                        }

                        $item->forceDelete();
                        $deleted++;
                    } catch (\Throwable $e) {
                        // Log and continue
                        $this->error('Gagal memproses arsip id=' . $item->id . ': ' . $e->getMessage());
                        report($e);
                    }
                }
            });

        $this->info("Selesai. Total arsip yang dihapus permanen: {$deleted}");

        return 0;
    }
}
