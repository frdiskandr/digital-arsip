<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Forms\Form as FormsForm;
use Filament\Tables\Table as TablesTable;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 4;

    public static function form(FormsForm $form): FormsForm
    {
        return $form->schema([
            TextInput::make('name')->label('Nama Perusahaan')->required(),
            Textarea::make('slogan')->label('Slogan Perusahaan')->rows(3),
            FileUpload::make('logo')
                ->label('Logo Perusahaan')
                ->image()
                ->directory('settings')
                ->disk('public')
                ->enableOpen()
                ->imagePreviewHeight(120)
                ->getUploadedFileUsing(fn($component, $file, $storedFileNames) => [
                    'name' => basename($file),
                    // We intentionally avoid calling storage->mimeType/size here to prevent filesystem
                    // interface issues in some environments; previews only need the URL.
                    'size' => 0,
                    'type' => null,
                    // Use relative storage path so preview loads from the same host the browser used to open the app
                    'url' => '/storage/' . ltrim($file, '/'),
                ]),
        ]);
    }

    public static function table(TablesTable $table): TablesTable
    {
        return $table->columns([
            TextColumn::make('name')->label('Nama Perusahaan')->searchable()->limit(30),
            ImageColumn::make('logo')->label('Logo')->rounded()->width(50),
            TextColumn::make('created_at')->label('Dibuat')->dateTime()->sortable(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSetting::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
