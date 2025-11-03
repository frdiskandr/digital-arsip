<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentUploadsUserWidget extends BaseWidget
{
    protected static ?string $heading = 'Aktivitas Upload Pengguna';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()
                    ->whereHas('arsip') // Memastikan hanya user yang pernah upload
                    ->withMax('arsip as arsip_max_created_at', 'created_at') // Mengambil timestamp upload terakhir
                    ->orderBy('arsip_max_created_at', 'desc') // Mengurutkan berdasarkan timestamp tersebut
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Pengguna'),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email'),
                Tables\Columns\TextColumn::make('arsip_max_created_at')
                    ->label('Upload Terakhir')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ]);
    }
}
