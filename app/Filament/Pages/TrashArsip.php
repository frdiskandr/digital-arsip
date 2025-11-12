<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Arsip;
use App\Models\Kategori;
use App\Models\Subjek;
use Illuminate\Support\Facades\Storage;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Notifications\Notification;
use App\Filament\Resources\ArsipResource; // Import ArsipResource

class TrashArsip extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationLabel = 'Arsip Terhapus';
    protected static ?string $navigationIcon = 'heroicon-o-trash';
    protected static ?int $navigationSort = 10;
    protected static ?string $navigationGroup = 'Arsip';

    public static function getNavigationIconColor(): string | array | null
    {
        return 'danger';
    }

    protected static string $view = 'filament.resources.arsip-resource.pages.trash-arsip';

    public function table(Table $table): Table
    {
        return $table
            ->query(Arsip::onlyTrashed())
            ->recordUrl(fn (Arsip $record): string => ArsipResource::getUrl('view', ['record' => $record]))
            ->columns([
                TextColumn::make('judul')
                    ->label('Judul Arsip')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->tooltip(fn(Arsip $record) => $record->judul),

                TextColumn::make('kategori.nama')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('subjek.nama')
                    ->label('Subjek')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Tanpa subjek'),

                TextColumn::make('user.name')
                    ->label('Dihapus oleh')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('deleted_at')
                    ->label('Tanggal Dihapus')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('kategori_id')
                    ->label('Filter Kategori')
                    ->options(Kategori::pluck('nama', 'id')),
                SelectFilter::make('subjek_id')
                    ->label('Filter Subjek')
                    ->options(Subjek::pluck('nama', 'id')),
                Filter::make('deleted_at')
                    ->form([
                        DatePicker::make('deleted_from')->label('Dihapus dari'),
                        DatePicker::make('deleted_until')->label('Dihapus sampai'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['deleted_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('deleted_at', '>=', $date),
                            )
                            ->when(
                                $data['deleted_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('deleted_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Action::make('restore')
                    ->label('Restore')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('success')
                    ->action(fn(Arsip $record) => $record->restore())
                    ->requiresConfirmation(),

                Action::make('forceDelete')
                    ->label('Permanent Delete')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->action(function (Arsip $record) {
                        if ($record->file_path && Storage::disk('public')->exists($record->file_path)) {
                            Storage::disk('public')->delete($record->file_path);
                        }
                        $record->forceDelete();
                    })
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                BulkAction::make('restore')
                    ->label('Restore Terpilih')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('success')
                    ->action(function (Collection $records) {
                        $records->each->restore();
                        Notification::make()->title('Arsip dipulihkan')->success()->send();
                    })
                    ->deselectRecordsAfterCompletion(),

                BulkAction::make('forceDelete')
                    ->label('Hapus Permanen Terpilih')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->action(function (Collection $records) {
                        $records->each(function (Arsip $record) {
                            if ($record->file_path && Storage::disk('public')->exists($record->file_path)) {
                                Storage::disk('public')->delete($record->file_path);
                            }
                            $record->forceDelete();
                        });
                        Notification::make()->title('Arsip dihapus permanen')->success()->send();
                    })
                    ->requiresConfirmation()
                    ->deselectRecordsAfterCompletion(),
            ])
            ->defaultSort('deleted_at', 'desc');
    }
}
