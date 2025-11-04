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

    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?string $navigationLabel = 'Arsip';
    protected static ?string $pluralModelLabel = 'Arsip';
    protected static ?string $modelLabel = 'Arsip';
    // protected static ?string $navigationGroup = 'Manajemen Arsip';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 10 ? 'primary' : 'primary';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('judul')
                    ->label('Judul Arsip')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('created_at')
                    ->label('Tanggal Arsip')
                    ->required()
                    ->default(now())
                    ->maxDate(now()),
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
                //   ->sortable()  ->preserveFilenames()
                //     ->openable()
                //     ->downloadable()
                //     ->required(),
                FileUpload::make('file_path')
                    ->label('File Arsip')
                    ->helperText('Upload file apapun (DOC, PDF, XLS, JPG, ZIP, dll)')
                    ->directory('arsip')
                    ->disk('public')
                    ->required()
                    ->downloadable()
                    ->openable()
                    ->maxSize(102400)
                    ->getUploadedFileNameForStorageUsing(
                        function (\Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file): string {
                            $fileName = $file->getClientOriginalName();
                            $extension = $file->getClientOriginalExtension();
                            $nameWithoutExtension = str_replace('.' . $extension, '', $fileName);

                            return date('Y-m-d-His') . '_' .
                                md5($nameWithoutExtension . time()) . '_' .
                                str_replace([' ', '#', '&', '{', '}', '<', '>', '*', '?', '/', '\\', '$', '!', '\'', '"', ':', '@', '+', '`', '|', '='], '-', $fileName);
                        }
                    )
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Nama Arsip (dengan deskripsi nama file asli, pemotongan, dan tooltip)
                Tables\Columns\TextColumn::make('judul')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->tooltip(fn(Arsip $record) => $record->judul)
                    ->description(fn(Arsip $record) => $record->original_file_name, position: 'below')
                    ->extraHeaderAttributes(['class' => 'w-[38rem]'])
                    ->extraCellAttributes(['class' => 'max-w-[38rem] truncate']),

                // Jenis Dokumen (ekstensi file)
                Tables\Columns\BadgeColumn::make('doc_type')
                    ->label('Jenis')
                    ->getStateUsing(function (Arsip $record) {
                        $name = $record->original_file_name ?: $record->file_path;
                        $ext = $name ? pathinfo($name, PATHINFO_EXTENSION) : null;
                        return strtoupper($ext ?: 'FILE');
                    })
                    ->color(fn($state) => match ($state) {
                        'PDF' => 'danger',
                        'XLS', 'XLSX' => 'success',
                        'DOC', 'DOCX' => 'primary',
                        default => 'gray',
                    })
                    ->extraHeaderAttributes(['class' => 'w-24'])
                    ->extraCellAttributes(['class' => 'w-24']),
                    // ->sortable(),

                // Kategori
                Tables\Columns\BadgeColumn::make('kategori.nama')
                    ->label('Kategori')
                    ->colors(['primary'])
                    ->searchable()
                    ->sortable()
                    ->extraHeaderAttributes(['class' => 'w-40'])
                    ->extraCellAttributes(['class' => 'w-40 truncate']),

                // Pengunggah (nama)
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pengunggah')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->tooltip(fn(Arsip $record) => $record->user?->name)
                    ->extraHeaderAttributes(['class' => 'w-40'])
                    ->extraCellAttributes(['class' => 'w-40 truncate']),

                // Tanggal Upload
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable()
                    ->extraHeaderAttributes(['class' => 'w-32'])
                    ->extraCellAttributes(['class' => 'w-32']),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori_id')
                    ->label('Kategori')
                    ->options(Kategori::pluck('nama', 'id')),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('view')
                        ->label('Lihat')
                        ->icon('heroicon-o-eye')
                        ->url(fn(Arsip $record) => ArsipResource::getUrl('view', ['record' => $record]))
                        ->visible(fn(Arsip $record) => $record->file_path && Storage::disk('public')->exists($record->file_path)),
                    Tables\Actions\Action::make('download')
                        ->label('Download')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->url(fn(Arsip $record) => $record->file_url)
                        ->openUrlInNewTab()
                        ->visible(fn(Arsip $record) => $record->file_path && Storage::disk('public')->exists($record->file_path)),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->label('')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori_id')
                    ->label('Filter By Kategori')
                    ->options(Kategori::pluck('nama', 'id')),
                Tables\Filters\Filter::make('tanggal_upload')
                    ->form([
                        Forms\Components\DatePicker::make('form')->label('Dari tanggal'),
                        Forms\Components\DatePicker::make('util')->label('Sampai tanggal'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['form'], fn(Builder $query, $date) => $query->whereDate('created_at', '>=', $date))
                            ->when($data['util'], fn(Builder $query, $date) => $query->whereDate('created_at', '<=', $date));
                    }),
            ])->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListArsips::route('/'),
            'create' => Pages\CreateArsip::route('/create'),
            'edit' => Pages\EditArsip::route('/{record}/edit'),
            'view' => Pages\ViewArsip::route('/{record}'),
        ];
    }
}
