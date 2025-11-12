<?php

namespace App\Filament\Resources\ArsipResource\Pages;

use App\Filament\Resources\ArsipResource;
use Filament\Resources\Pages\ViewRecord;

use Filament\Actions\Action;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class ViewArsip extends ViewRecord
{
    protected static string $resource = ArsipResource::class;

    protected static ?string $title = 'Detail Arsip';

    protected static ?string $navigationLabel = "lihat arsip";


    protected static string $view = 'filament.resources.arsip-resource.pages.view-arsip';

    protected function getActions(): array
    {
        return [
            Action::make('share')
                ->label('Bagikan')
                ->icon('heroicon-o-share')
                ->modalContent(fn() => view(
                    'filament.resources.arsip-resource.pages.share-modal',
                    ['url' => ArsipResource::getUrl('view', ['record' => $this->record])]
                ))

                ->modalSubmitAction(false) // Hides the submit button
                ->modalCancelAction(false), // Hides the cancel button
            Action::make('download')
                ->label('Unduh')
                ->icon('heroicon-o-arrow-down-tray')
                ->url(fn() => $this->record?->file_url)
                ->openUrlInNewTab()
                ->visible(fn() => $this->record && $this->record->file_path && Storage::disk('public')->exists($this->record->file_path)),
        ];
    }

    protected function resolveRecord(int | string $key): Model
    {
        return static::getResource()::getEloquentQuery()->withTrashed()->findOrFail($key);
    }
}
