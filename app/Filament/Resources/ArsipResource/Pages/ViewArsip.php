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
                ->mountUsing(function (Model $record, \App\Services\ArsipStatService $service) {
                    $service->recordShare($record);
                    return [];
                })

                ->modalSubmitAction(false) // Hides the submit button
                ->modalCancelAction(false), // Hides the cancel button
            Action::make('download')
                ->label('Unduh')
                ->icon('heroicon-o-arrow-down-tray')
                ->url(fn() => route('arsip.download', ['record' => $this->record]))
                ->openUrlInNewTab()
                ->visible(fn() => $this->record && $this->record->file_path && Storage::disk('local')->exists($this->record->file_path)),
        ];
    }

    protected function resolveRecord(int | string $key): Model
    {
        return static::getResource()::getEloquentQuery()->withTrashed()->findOrFail($key);
    }

    public function getRelationManagers(): array
    {
        return parent::getRelationManagers();
    }

    /**
     * Provide additional view data (paginated versions and activities) so the Blade
     * view doesn't run heavy queries directly.
     *
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        $record = $this->record;

        // Paginate versions (5 per page)
        $versions = $record->versions()->orderBy('version', 'desc')->paginate(5);

        // Paginate activities (5 per page) if activity model exists
        $activities = null;
        if (class_exists(\Spatie\Activitylog\Models\Activity::class)) {
            $activities = \Spatie\Activitylog\Models\Activity::where('subject_type', \App\Models\Arsip::class)
                ->where('subject_id', $record->id)
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        }

        return array_merge(parent::getViewData(), [
            'versions' => $versions,
            'activities' => $activities,
        ]);
    }
}
