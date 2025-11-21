<?php

namespace App\Services;

use App\Models\Arsip;

class ArsipStatService
{
    /**
     * Increment the download count for the given archive.
     *
     * @param Arsip $arsip
     * @return void
     */
    public function recordDownload(Arsip $arsip): void
    {
        $arsip->increment('download_count');
    }

    /**
     * Increment the share count for the given archive.
     *
     * @param Arsip $arsip
     * @return void
     */
    public function recordShare(Arsip $arsip): void
    {
        $arsip->increment('share_count');
    }
}
