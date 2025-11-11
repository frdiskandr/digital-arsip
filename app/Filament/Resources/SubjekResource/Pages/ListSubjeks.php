<?php

namespace App\Filament\Resources\SubjekResource\Pages;

use App\Filament\Resources\SubjekResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubjeks extends ListRecords
{
    protected static string $resource = SubjekResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
