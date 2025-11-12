<?php

namespace App\Filament\Resources\ArsipResource\Pages;

use App\Filament\Resources\ArsipResource;
use Filament\Resources\Pages\ViewRecord;

use Illuminate\Database\Eloquent\Model;

class ViewArsip extends ViewRecord
{
    protected static string $resource = ArsipResource::class;

    protected static ?string $title = 'Detail Arsip';

    protected static string $view = 'filament.resources.arsip-resource.pages.view-arsip';

    protected function resolveRecord(int | string $key): Model
    {
        return static::getResource()::getEloquentQuery()->withTrashed()->findOrFail($key);
    }
}
