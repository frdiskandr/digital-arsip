<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Services\ArsipStatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ArsipDownloadController extends Controller
{
    /**
     * Handle the incoming request to download an archive file.
     *
     * @param Arsip $record The archive record.
     * @param ArsipStatService $statService
     * @return StreamedResponse
     */
    public function __invoke(Arsip $record, ArsipStatService $statService)
    {
        // Use the existing ArsipPolicy to authorize the user.
        Gate::authorize('view', $record);

        // Check if the file exists on the 'local' disk.
        if (!Storage::disk('local')->exists($record->file_path)) {
            abort(404, 'File not found.');
        }

        // Record the download
        $statService->recordDownload($record);

        // Download the file.
        return Storage::disk('local')->download($record->file_path, $record->original_file_name);
    }
}
