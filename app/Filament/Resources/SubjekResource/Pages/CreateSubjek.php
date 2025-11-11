<?php

namespace App\Filament\Resources\SubjekResource\Pages;

use App\Filament\Resources\SubjekResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSubjek extends CreateRecord
{
    protected static string $resource = SubjekResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
