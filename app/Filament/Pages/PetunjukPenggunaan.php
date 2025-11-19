<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class PetunjukPenggunaan extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'Petunjuk Penggunaan';
    protected static ?string $navigationGroup = 'Settings';

    protected static string $view = 'filament.pages.petunjuk-penggunaan';

    protected static ?string $title = 'Petunjuk Penggunaan';

    protected static ?int $navigationSort = 11; // After Trash Arsip

    public static function shouldRegisterNavigation(): bool
    {
        return true; // Or add your authorization logic here
    }
}
