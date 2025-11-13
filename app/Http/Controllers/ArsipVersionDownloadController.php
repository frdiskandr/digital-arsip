<?php

namespace App\Http\Controllers;

use App\Models\ArsipVersion;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ArsipVersionDownloadController extends Controller
{
    /**
     * Handle the incoming request to download a specific archive version.
     *
     * @param ArsipVersion $version The specific archive version record.
     * @return StreamedResponse
     */
    public function __invoke(ArsipVersion $version)
    {
        // Use the main ArsipPolicy to authorize the user against the parent archive.
        Gate::authorize('view', $version->arsip);

        // Check if the file exists on the 'local' disk.
        if (!Storage::disk('local')->exists($version->file_path)) {
            abort(404, 'File not found for this version.');
        }

        // Force download the file, using its original name.
        return Storage::disk('local')->download($version->file_path, $version->original_file_name);
    }
}
