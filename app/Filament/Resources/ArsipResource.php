<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArsipResource\Pages;
use App\Filament\Resources\ArsipResource\RelationManagers;
use App\Models\Arsip;
use App\Models\Kategori;
use App\Models\Subjek;
use emmanpbarrameda\FilamentTakePictureField\Forms\Components\TakePicture;
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


use App\Filament\Resources\ArsipResource\RelationManagers\VersionsRelationManager;

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
                Forms\Components\Section::make('Detail Arsip')
                    ->description('Masukkan informasi utama mengenai arsip ini.')
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                            ->label('Judul Arsip')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->rows(3),
                    ]),

                Forms\Components\Section::make('Klasifikasi & File')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\Select::make('kategori_id')
                                ->label('Fungsi')
                                ->options(Kategori::all()->pluck('nama', 'id'))
                                ->required(),
                            Forms\Components\Select::make('subjek_id')
                                ->label('Subjek')
                                ->options(Subjek::all()->pluck('nama', 'id'))
                                ->nullable()
                                ->helperText('Opsional'),
                        ]),
                        FileUpload::make('file_path')
                            ->label('File Arsip')
                            ->helperText('Upload file apapun (DOC, PDF, XLS, JPG, ZIP, dll)')
                            ->directory('arsip')
                            ->disk('local')
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
                            ),
                    ]),

                Forms\Components\Section::make('Metadata')
                    ->schema([
                        Forms\Components\DatePicker::make('created_at')
                            ->label('Tanggal Arsip')
                            ->required()
                            ->default(now())
                            ->maxDate(now()),
                    ]),
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
                    ->extraHeaderAttributes(['class' => 'w-[28rem]'])
                    ->extraCellAttributes(['class' => 'max-w-[28rem] truncate']),

                // Jenis Dokumen (ekstensi file)
                Tables\Columns\BadgeColumn::make('doc_type')
                    ->label('Jenis')
                    ->getStateUsing(function (Arsip $record) {
                        echo '<script>console.log("Debug record:", ' . json_encode($record) . ');</script>';
                        $name = $record->original_file_name ?: $record->file_path;
                        $ext = $name ? pathinfo($name, PATHINFO_EXTENSION) : null;
                        $versions = $record->versions()->get();
                        echo '<script>console.log("Debug versions:", ' . json_encode($versions) . ');</script>';
                        return strtoupper($ext ?: 'FILE');
                    })
                    ->color(fn($state) => match ($state) {
                        // Adobe PDF
                        'PDF' => 'danger',

                        // Microsoft Office
                        'DOC', 'DOCX' => 'primary',
                        'XLS', 'XLSX' => 'success',
                        'PPT', 'PPTX' => 'warning',

                        // Images
                        'JPG', 'JPEG', 'PNG', 'GIF', 'WEBP', 'TIFF' => 'info',

                        // Archives
                        'ZIP', 'RAR', '7Z' => 'secondary',

                        // Text / others
                        'TXT', 'MD' => 'gray',

                        // Default fallback
                        default => 'gray',
                    })
                    ->extraHeaderAttributes(['class' => 'w-24'])
                    ->extraCellAttributes(['class' => 'w-24']),
                // ->sortable(),

                // Kategori
                Tables\Columns\TextColumn::make('kategori.nama')
                    ->label('Fungsi')
                    ->formatStateUsing(fn($state, Arsip $record) => view('filament.components.kategori-badge', ['name' => $state, 'color' => $record->kategori?->color ?? '#6b7280'])->render())
                    ->html()
                    ->searchable()
                    ->sortable()
                    ->extraHeaderAttributes(['class' => 'max-w-40 '])
                    ->extraCellAttributes(['class' => 'max-w-40 ']),

                // Subjek (render colored badge using subjek color)
                Tables\Columns\TextColumn::make('subjek.nama')
                    ->label('Subjek')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn($state, Arsip $record) => view('filament.components.subjek-badge', ['name' => $state, 'color' => $record->subjek?->color ?? '#6b7280'])->render())
                    ->html()
                    ->extraHeaderAttributes(['class' => 'w-40'])
                    ->extraCellAttributes(['class' => 'w-40']),

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
                        ->visible(fn(Arsip $record) => $record->file_path && Storage::disk('local')->exists($record->file_path)),
                    Tables\Actions\Action::make('download')
                        ->label('Download')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->url(fn(Arsip $record) => route('arsip.download', ['record' => $record]))
                        ->openUrlInNewTab()
                        ->visible(fn(Arsip $record) => $record->file_path && Storage::disk('local')->exists($record->file_path)),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->label('')
            ])
            ->bulkActions([
                    Tables\Actions\DeleteBulkAction::make(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori_id')
                    ->label('Filter By fungsi arsip')
                    ->options(Kategori::pluck('nama', 'id')),
                Tables\Filters\SelectFilter::make('subjek_id')
                    ->label('Filter By Subjek')
                    ->options(Subjek::pluck('nama', 'id')),
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
            VersionsRelationManager::class,
            RelationManagers\ActivitiesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArsips::route('/'),
            'create' => Pages\CreateArsip::route('/create'),
            'trash' => Pages\TrashArsip::route('/trash'),
            'edit' => Pages\EditArsip::route('/{record}/edit'),
            'view' => Pages\ViewArsip::route('/{record}'),
        ];
    }
}
