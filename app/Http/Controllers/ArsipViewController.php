<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ArsipViewController extends Controller
{
    /**
     * Handle the incoming request to view or download an archive file.
     *
     * @param Arsip $record The archive record.
     * @return StreamedResponse|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(Arsip $record)
    {
        // Use the existing ArsipPolicy to authorize the user.
        // This will automatically throw an AuthorizationException if the user is not allowed.
        Gate::authorize('view', $record);

        // Check if the file exists on the 'local' disk.
        if (!Storage::disk('local')->exists($record->file_path)) {
            // If not, abort with a 404 error.
            abort(404, 'File not found.');
        }

        // Stream the file. 
        // Using response() instead of download() allows the browser to display
        // the file inline if it's a supported type (like PDF, image, text).
        return Storage::disk('local')->response($record->file_path);
    }
}
