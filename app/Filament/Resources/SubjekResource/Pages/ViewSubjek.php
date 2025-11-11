<?php

namespace App\Filament\Resources\SubjekResource\Pages;

use App\Filament\Resources\SubjekResource;
use Filament\Resources\Pages\ViewRecord;

class ViewSubjek extends ViewRecord
{
    protected static string $resource = SubjekResource::class;
    protected static ?string $title = 'Detail Subjek';
}
