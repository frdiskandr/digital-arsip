<?php

namespace App\Filament\Resources\KategoriResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ActivitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'activities';

    protected static ?string $recordTitleAttribute = 'description';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('description')->label('Action')->wrap(),
                Tables\Columns\TextColumn::make('causer.name')->label('User')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('created_at')->label('When')->dateTime('d M Y H:i')->sortable(),
            ])
            ->filters([])
            ->headerActions([])
            ->actions([])
            ->bulkActions([]);
    }
}
