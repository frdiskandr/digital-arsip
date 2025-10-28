<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArsipResource\Pages;
use App\Filament\Resources\ArsipResource\RelationManagers;
use App\Models\Arsip;
use App\Models\Kategori;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class ArsipResource extends Resource
{
    protected static ?string $model = Arsip::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Arsip';
    protected static ?string $pluralModelLabel = 'Arsip';
    protected static ?string $modelLabel = 'Arsip';
    protected static ?string $navigationGroup = 'Manajemen Arsip';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('judul')
                    ->label('Judul Arsip')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('deskripsi')
                    ->label('Deskripsi')
                    ->rows(3),
                Forms\Components\Select::make('kategori_id')
                    ->label('Kategori')
                    ->options(Kategori::all()->pluck('nama', 'id'))
                    ->required(),
                // Forms\Components\FileUpload::make('file_path')
                //     ->label('File Arsip (PDF/DOC)')
                //     ->directory('arsip')
                //     ->preserveFilenames()
                //     ->openable()
                //     ->downloadable()
                //     ->required(),
                FileUpload::make('file_path')
                    ->label('File Arsip (PDF/DOC)')
                    ->directory('arsip')
                    ->disk('public')
                    ->required()
                    ->downloadable()
                    ->openable()
                    ->preserveFilenames()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')->label('Judul')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('kategori.nama')->label('Kategori')->sortable(),
                Tables\Columns\TextColumn::make('user.name')->label('Pengunggah'),
                Tables\Columns\TextColumn::make('created_at')->label('Tanggal Upload')->dateTime('d M Y H:i'),
                Tables\Columns\IconColumn::make('file_path')
                    ->label('File')
                    ->boolean()
                    ->getStateUsing(fn($record) => Storage::exists($record->file_path)),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori_id')
                    ->label('Kategori')
                    ->options(Kategori::pluck('nama', 'id')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArsips::route('/'),
            'create' => Pages\CreateArsip::route('/create'),
            'edit' => Pages\EditArsip::route('/{record}/edit'),
            'view' => Pages\ViewArsip::route('/{record}'),
        ];
    }
}
