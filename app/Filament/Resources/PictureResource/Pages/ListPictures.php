<?php

namespace App\Filament\Resources\PictureResource\Pages;

use App\Filament\Resources\PictureResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;

class ListPictures extends ListRecords
{
    protected static string $resource = PictureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
