<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuditLogResource\Pages;
use App\Models\AuditLog;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

class AuditLogResource extends Resource
{
    protected static ?string $model = AuditLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationLabel = 'Audit Logs';
    protected static ?string $pluralModelLabel = 'Audit Logs';
    protected static ?string $modelLabel = 'Audit Log';
    protected static ?string $navigationGroup = 'Settings';

    public static function form(\Filament\Forms\Form $form): \Filament\Forms\Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('#')->sortable()->toggleable(false),
                TextColumn::make('user.name')->label('User')->sortable()->searchable(),
                TextColumn::make('action')->label('Action')->sortable()->searchable(),
                TextColumn::make('route')->label('Route')->limit(30),
                TextColumn::make('method')->label('Method')->badge()->sortable(),
                TextColumn::make('model_type')->label('Model')->limit(30),
                TextColumn::make('model_id')->label('Model ID'),
                TextColumn::make('created_at')->label('When')->dateTime('d M Y H:i'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('action')
                    ->options([
                        'create' => 'Create',
                        'update' => 'Update',
                        'delete' => 'Delete',
                    ]),
            ])
            ->actions([])
            ->bulkActions([])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAuditLogs::route('/'),
        ];
    }
}
