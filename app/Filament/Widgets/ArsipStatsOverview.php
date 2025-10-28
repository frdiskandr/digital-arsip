<?php

namespace App\Filament\Widgets;

use App\Models\Arsip;
use App\Models\Kategori;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ArsipStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Card::make('Total Arsip', Arsip::count())
                ->description('Semua arsip tersimpan')
                ->icon('heroicon-o-archive-box')
                ->color('success'),

            Card::make('Total Kategori', Kategori::count())
                ->description('Kategori arsip terdaftar')
                ->icon('heroicon-o-folder')
                ->color('info'),

            Card::make('Total Pengunggah', User::has('arsip')->count())
                ->description('User yang terdaftar')
                ->icon('heroicon-o-user-group')
                ->color('warning'),
        ];
    }
}
