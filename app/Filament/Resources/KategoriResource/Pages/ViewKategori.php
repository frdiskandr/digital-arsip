<?php

namespace App\Filament\Resources\KategoriResource\Pages;

use App\Filament\Resources\KategoriResource;
use Filament\Resources\Pages\ViewRecord;

class ViewKategori extends ViewRecord
{
    protected static string $resource = KategoriResource::class;
    protected static ?string $title = 'Detail Kategori';
    protected static string $view = 'filament.resources.kategori-resource.pages.view-kategori';
}
