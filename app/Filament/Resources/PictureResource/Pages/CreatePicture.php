<?php

namespace App\Filament\Resources\PictureResource\Pages;

use App\Filament\Resources\PictureResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Arsip;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Filament\Notifications\Notification;

class CreatePicture extends CreateRecord
{
    protected static string $resource = PictureResource::class;

    public function create(bool $another = false): void
    {
        $state = $this->form->getState();

        // Collect taken photo paths
        $photos = $state['photos'] ?? [];
        $paths = [];
        foreach ($photos as $item) {
            if (!empty($item['path'])) {
                $paths[] = $item['path'];
            }
        }

        if (empty($paths)) {
            Notification::make()->danger()->title('Tidak ada foto yang diambil.')->send();
            return;
        }

        // Prepare absolute file paths for Dompdf
        $images = [];
        foreach ($paths as $p) {
            if (Storage::disk('public')->exists($p)) {
                // use storage_path for Dompdf local file access
                $images[] = storage_path('app/public/' . ltrim($p, '/'));
            }
        }

        if (empty($images)) {
            Notification::make()->danger()->title('Gambar tidak ditemukan pada storage.')->send();
            return;
        }

        // Render PDF with a blade view
        $html = view('pdf.picture_to_pdf', ['images' => $images])->render();

        // Generate PDF via Dompdf facade
        $pdf = PDF::loadHTML($html)->setPaper('a4', 'portrait');
        $pdfContent = $pdf->output();

        // Store PDF in public disk under arsip/
        $filename = 'arsip/' . date('Y-m-d-His') . '_' . Str::random(8) . '.pdf';
        Storage::disk('public')->put($filename, $pdfContent);

        // Create Arsip record
        $arsip = Arsip::create([
            'judul' => $state['judul'] ?? 'Dokumen Foto',
            'deskripsi' => $state['deskripsi'] ?? null,
            'kategori_id' => $state['kategori_id'] ?? null,
            'file_path' => $filename,
            'user_id' => Auth::id(),
            'tanggal_arsip' => now(),
        ]);

        // Delete original uploaded images (they were only used to build the PDF)
        foreach ($paths as $p) {
            try {
                if (Storage::disk('public')->exists($p)) {
                    Storage::disk('public')->delete($p);
                }
            } catch (\Throwable $e) {
                // don't break the flow if a file can't be deleted; log for later inspection
                logger()->warning('Failed to delete temporary picture: ' . $p . ' — ' . $e->getMessage());
            }
        }

        Notification::make()->success()->title('PDF berhasil dibuat dan disimpan ke Arsip.')->send();

        // Redirect to Arsip index page
        $this->redirect(\App\Filament\Resources\ArsipResource::getUrl('index'));
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
