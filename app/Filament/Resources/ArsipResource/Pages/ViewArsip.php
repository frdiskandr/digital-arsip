<?php

namespace App\Filament\Resources\ArsipResource\Pages;

use App\Filament\Resources\ArsipResource;
use Filament\Resources\Pages\ViewRecord;

class ViewArsip extends ViewRecord
{
    protected static string $resource = ArsipResource::class;

    protected static ?string $title = 'Detail Arsip';
}
