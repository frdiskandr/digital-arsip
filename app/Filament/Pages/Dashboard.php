<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\ArsipStatsOverview;
use App\Filament\Widgets\ArsipChart;
use App\Filament\Widgets\ArsipKategoriChart;
use Filament\Widgets\AccountWidget;
use App\Filament\Widgets\CompanyProfileWidget;
use App\Filament\Widgets\RecentUploadsUserWidget;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            ArsipStatsOverview::class,
            ArsipChart::class,
            ArsipKategoriChart::class,
            AccountWidget::class,
            CompanyProfileWidget::class,
            RecentUploadsUserWidget::class,
        ];
    }
}
