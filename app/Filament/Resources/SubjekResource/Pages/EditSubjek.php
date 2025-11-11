<?php

namespace App\Filament\Resources\SubjekResource\Pages;

use App\Filament\Resources\SubjekResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubjek extends EditRecord
{
    protected static string $resource = SubjekResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
