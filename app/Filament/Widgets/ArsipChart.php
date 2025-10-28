<?php

namespace App\Filament\Widgets;

use App\Models\Arsip;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ArsipChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        $data = Arsip::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        $labels = $data->pluck('month')->map(function ($m) {
            return date('F', mktime(0, 0, 0, $m, 1)); // Januari, Februari, ...
        })->toArray();

        $values = $data->pluck('total')->toArray();

        return [
             'datasets' => [
                [
                    'label' => 'Jumlah Arsip',
                    'data' => $values,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
