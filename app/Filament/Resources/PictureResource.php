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
                Forms\Components\Card::make()->schema([
                    Forms\Components\Grid::make([
                        // 1 column by default (mobile), 2 columns on small screens and up
                        'default' => 1,
                        'sm' => 2,
                    ])->schema([
                        // Photo area (left column)
                        Forms\Components\Repeater::make('photos')
                            ->label('Foto')
                            ->schema([
                                TakePicture::make('path')
                                    ->label('Foto')
                                    ->directory('arsip/foto')
                                    ->disk('public')
                                    ->required(),
                            ])
                            ->columns(1)
                            ->minItems(1)
                            ->createItemButtonLabel('Tambah Foto')
                            ->columnSpan([
                                'default' => 'full', // on mobile the photo area should be full width
                                'sm' => 1, // on small+ screens occupy the left column
                            ]),

                        // Metadata area (right column)
                        Forms\Components\TextInput::make('judul')
                            ->label('Judul Arsip')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan([
                                'default' => 'full',
                                'sm' => 1,
                            ]),

                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->rows(4)
                            ->columnSpan([
                                'default' => 'full',
                                'sm' => 2, // span both columns on small+ screens
                            ]),

                        Forms\Components\Select::make('kategori_id')
                            ->label('Kategori')
                            ->options(Kategori::pluck('nama', 'id'))
                            ->required()
                            ->columnSpan([
                                'default' => 'full',
                                'sm' => 1,
                            ]),
                        Forms\Components\Select::make('subjek_id')
                            ->label('Subjek')
                            ->options(Subjek::pluck('nama', 'id'))
                            ->nullable()
                            ->searchable()
                            ->columnSpan([
                                'default' => 'full',
                                'sm' => 1,
                            ]),
                    ])->columns([
                        'default' => 1,
                        'sm' => 2,
                    ]),

                    Forms\Components\Placeholder::make('info')
                        ->content('Ambil foto satu per satu. Gunakan tombol "Tambah Foto" untuk menambah foto. Setelah selesai, klik Simpan untuk menggabungkan foto menjadi satu dokumen PDF yang akan disimpan di Arsip.'),
                ])->columnSpan('full'),
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
