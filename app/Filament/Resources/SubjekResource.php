<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubjekResource\Pages;
use App\Filament\Resources\SubjekResource\RelationManagers;
use App\Models\Subjek;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SubjekResource extends Resource
{
    protected static ?string $model = Subjek::class;
    protected static ?string $navigationIcon = 'heroicon-o-bookmark';

    protected static ?string $navigationLabel = 'Subjek Arsip';
    protected static ?string $pluralModelLabel = 'Subjek Arsip';
    protected static ?string $modelLabel = 'Subjek Arsip';
     protected static ?string $navigationGroup = 'Manajemen Arsip';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string
    {
        return 'primary';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->label('Nama Subjek')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('deskripsi')
                    ->label('Deskripsi')
                    ->rows(3)
                    ->nullable(),
                Forms\Components\ColorPicker::make('color')
                    ->label('Warna')
                    ->default('#3B82F6')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')->label('Nama')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('deskripsi')->label('Deskripsi')->limit(50),
                Tables\Columns\TextColumn::make('created_at')->label('Dibuat')->dateTime('d M Y'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ActivitiesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubjeks::route('/'),
            'create' => Pages\CreateSubjek::route('/create'),
            'edit' => Pages\EditSubjek::route('/{record}/edit'),
            'view' => Pages\ViewSubjek::route('/{record}'),
        ];
    }
}
