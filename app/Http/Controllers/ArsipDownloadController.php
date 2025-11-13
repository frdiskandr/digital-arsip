<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ArsipDownloadController extends Controller
{
    /**
     * Handle the incoming request to force download an archive file.
     *
     * @param Arsip $record The archive record.
     * @return StreamedResponse|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(Arsip $record)
    {
        // Authorize the user using the existing ArsipPolicy.
        Gate::authorize('view', $record);

        // Check if the file exists on the 'local' disk.
        if (!Storage::disk('local')->exists($record->file_path)) {
            abort(404, 'File not found.');
        }

        // Force download the file, using its original name.
        return Storage::disk('local')->download($record->file_path, $record->original_file_name);
    }
}
