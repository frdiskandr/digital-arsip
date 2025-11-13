<?php

namespace App\Filament\Resources\ArsipResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VersionsRelationManager extends RelationManager
{
    protected static string $relationship = 'versions';

    protected static ?string $title = 'Riwayat Versi';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // We don't want to create/edit versions from here, so this can be simple.
                Forms\Components\TextInput::make('version')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('version')
            ->columns([
                Tables\Columns\TextColumn::make('version')
                    ->label('Versi')
                    ->sortable(),
                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Diubah oleh'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Versi')
                    ->dateTime('d M Y, H:i'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(), // Disable creating versions manually
            ])
            ->actions([
                Tables\Actions\Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn ($record) => route('arsip.version.download', ['version' => $record]))
                    ->openUrlInNewTab(),
                // Tables\Actions\EditAction::make(), // Disable editing old versions
                // Tables\Actions\DeleteAction::make(), // Disable deleting old versions
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])
            ->defaultSort('version', 'desc');
    }
}