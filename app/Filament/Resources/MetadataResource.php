<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MetadataResource\Pages;
use App\Models\Arsip;
use App\Models\Kategori;
use App\Models\Subjek;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MetadataResource extends Resource
{
    protected static ?string $model = Arsip::class;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';
    protected static ?string $navigationLabel = 'Metadata';
    protected static ?string $modelLabel = 'Metadata';
    protected static ?string $slug = 'metadata';
    protected static ?string $navigationGroup = 'Manajemen Arsip';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Read-only view for metadata if needed, or just keep it empty since we focus on the table
                Forms\Components\TextInput::make('judul')
                    ->readonly(),
                Forms\Components\Textarea::make('deskripsi')
                    ->readonly(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kategori.nama')
                    ->label('Kategori')
                    ->sortable(),
                Tables\Columns\TextColumn::make('subjek.nama')
                    ->label('Subjek')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pengunggah')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Upload')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('original_file_name')
                    ->label('Nama File Asli')
                    ->searchable(),
                Tables\Columns\TextColumn::make('version')
                    ->label('Versi')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori_id')
                    ->label('Kategori')
                    ->options(Kategori::pluck('nama', 'id')),
                Tables\Filters\SelectFilter::make('subjek_id')
                    ->label('Subjek')
                    ->options(Subjek::pluck('nama', 'id')),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('created_until')->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                // No specific actions needed per row for now
            ])
            ->bulkActions([
                // No bulk actions needed for now
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMetadata::route('/'),
        ];
    }
    
    public static function canCreate(): bool
    {
        return false;
    }
}
