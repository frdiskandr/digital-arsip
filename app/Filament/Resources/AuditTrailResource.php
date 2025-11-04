<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuditTrailResource\Pages;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;

class AuditTrailResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $label = 'Audit Trail';

    protected static ?string $pluralLabel = 'Audit Trails';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Placeholder::make('description')
                            ->label('Aktivitas')
                            ->content(fn(Activity $record): string => $record->description),
                        Placeholder::make('subject')
                            ->label('Model')
                            ->content(function (Activity $record): string {
                                if (!$record->subject) {
                                    return '-';
                                }
                                $subject = $record->subject;
                                $subjectType = class_basename($subject);
                                $subjectName = $subject->name ?? $subject->nomor_arsip ?? $subject->id;
                                return "{$subjectType} #{$subjectName}";
                            }),
                        Placeholder::make('causer')
                            ->label('Dilakukan oleh')
                            ->content(fn(Activity $record): string => $record->causer ? $record->causer->name : 'System'),
                        Placeholder::make('created_at')
                            ->label('Waktu')
                            ->content(fn(Activity $record): string => $record->created_at->toFormattedDateString() . ' ' . $record->created_at->toTimeString()),
                    ])->columns(2),
                Card::make()
                    ->schema([
                        KeyValue::make('properties.attributes')
                            ->label('Data Baru'),
                        KeyValue::make('properties.old')
                            ->label('Data Lama'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('description')
                    ->label('Aktivitas')
                    ->searchable()
                    ->sortable()
                    ->color(fn(string $state): string => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        default => 'secondary',
                    })
                    ->badge(),
                Tables\Columns\TextColumn::make('subject_type')
                    ->label('Model')
                    ->formatStateUsing(fn(?string $state): string => $state ? class_basename($state) : '-')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('causer.name')
                    ->label('Pengguna')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make()->color('info'),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAuditTrails::route('/'),
            'view' => Pages\ViewAuditTrail::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }
}
