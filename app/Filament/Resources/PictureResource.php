<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PictureResource\Pages;
use App\Models\Picture;
use App\Models\Kategori;
use App\Models\Subjek;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use emmanpbarrameda\FilamentTakePictureField\Forms\Components\TakePicture;

class PictureResource extends Resource
{
    protected static ?string $model = Picture::class;

    protected static ?string $navigationIcon = 'heroicon-o-camera';
    protected static ?string $navigationLabel = 'Picture to PDF';
    protected static ?string $pluralModelLabel = 'Pictures';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->columns(3)
                    ->schema([
                        // Main column for photo repeater
                        Forms\Components\Section::make('Ambil Foto')
                            ->columnSpan(2)
                            ->schema([
                                Forms\Components\Repeater::make('photos')
                                    ->label('Foto')
                                    ->schema([
                                        TakePicture::make('path')
                                            ->label('Ambil Gambar')
                                            ->directory('arsip/foto')
                                            ->disk('local')
                                            ->required(),
                                    ])
                                    ->columns(1)
                                    ->minItems(1)
                                    ->createItemButtonLabel('Tambah Foto'),
                            ]),

                        // Sidebar for metadata and instructions
                        Forms\Components\Grid::make()
                            ->columnSpan(1)
                            ->schema([
                                Forms\Components\Section::make('Detail Dokumen')
                                    ->schema([
                                        Forms\Components\TextInput::make('judul')
                                            ->label('Judul Arsip')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\Select::make('kategori_id')
                                            ->label('Fungsi')
                                            ->options(Kategori::pluck('nama', 'id'))
                                            ->required(),
                                        Forms\Components\Select::make('subjek_id')
                                            ->label('Subjek')
                                            ->options(Subjek::pluck('nama', 'id'))
                                            ->nullable()
                                            ->searchable(),
                                        Forms\Components\Textarea::make('deskripsi')
                                            ->label('Deskripsi')
                                            ->rows(4),
                                    ]),
                                Forms\Components\Section::make('Petunjuk')
                                    ->schema([
                                        Forms\Components\Placeholder::make('info')
                                            ->content('Ambil foto satu per satu. Gunakan tombol "Tambah Foto" untuk menambah foto. Setelah selesai, klik Simpan untuk menggabungkan foto menjadi satu dokumen PDF yang akan disimpan di Arsip.'),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID'),
                Tables\Columns\TextColumn::make('path')->label('Path')->limit(50),
                Tables\Columns\TextColumn::make('created_at')->label('Uploaded')->date(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            // Open the create page directly when user clicks the resource in navigation
            'index' => Pages\CreatePicture::route('/'),
            'create' => Pages\CreatePicture::route('/create'),
        ];
    }
}
