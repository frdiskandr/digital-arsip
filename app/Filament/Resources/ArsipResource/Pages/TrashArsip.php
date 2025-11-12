<?php

namespace App\Filament\Resources\ArsipResource\Pages;

use App\Filament\Resources\ArsipResource;
use Filament\Resources\Pages\Page;
use App\Models\Arsip;
use Illuminate\Support\Facades\Storage;

class TrashArsip extends Page
{
    protected static string $resource = ArsipResource::class;

    protected static string $view = 'filament.resources.arsip-resource.pages.trash-arsip';

    public $trashed = null;

    public function mount(): void
    {
        $this->loadTrashed();
    }

    public function loadTrashed(): void
    {
        $this->trashed = Arsip::onlyTrashed()->with(['kategori', 'subjek', 'user'])->get();
    }

    public function restore(int $id): void
    {
        $record = Arsip::onlyTrashed()->findOrFail($id);
        $record->restore();
        $this->loadTrashed();
        $this->dispatchBrowserEvent('filament-notify', ['message' => 'Arsip dikembalikan.']);
    }

    public function forceDelete(int $id): void
    {
        $record = Arsip::onlyTrashed()->findOrFail($id);

        // delete physical file if exists
        if ($record->file_path && Storage::disk('public')->exists($record->file_path)) {
            Storage::disk('public')->delete($record->file_path);
        }

        $record->forceDelete();
        $this->loadTrashed();
        $this->dispatchBrowserEvent('filament-notify', ['message' => 'Arsip dihapus secara permanen.']);
    }
}
