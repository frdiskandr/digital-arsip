<?php

namespace App\Filament\Widgets;

use App\Models\Arsip;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ArsipChart extends ChartWidget
{
    protected static ?string $heading = 'Jumlah Arsip per Bulan';

    protected static ?int $sort = 2;

    public function getColumnSpan(): int | string | array
    {
        return [
            'md' => 2,
            'lg' => 2,
            'xl' => 2,
        ];
    }



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
                    'backgroundColor' => 'rgba(59, 130, 246, 0.35)',
                    'borderColor' => '#3B82F6',
                    'borderWidth' => 2,
                    'borderRadius' => 12,
                    'borderSkipped' => false,
                    'hoverBackgroundColor' => 'rgba(37, 99, 235, 0.55)',
                    'hoverBorderColor' => '#1D4ED8',
                    'maxBarThickness' => 42,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'layout' => [
                'padding' => [
                    'top' => 16,
                    'right' => 16,
                    'bottom' => 16,
                    'left' => 12,
                ],
            ],
            'animation' => [
                'duration' => 600,
                'easing' => 'easeOutQuart',
            ],
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
                'tooltip' => [
                    'backgroundColor' => '#0F172A',
                    'titleColor' => '#F8FAFC',
                    'bodyColor' => '#E2E8F0',
                    'padding' => 12,
                    'cornerRadius' => 8,
                    'displayColors' => false,
                ],
            ],
            'scales' => [
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                    'ticks' => [
                        'color' => '#475569',
                        'font' => [
                            'size' => 12,
                            'weight' => '500',
                        ],
                        'maxRotation' => 0,
                        'minRotation' => 0,
                    ],
                ],
                'y' => [
                    'beginAtZero' => true,
                    'grid' => [
                        'color' => 'rgba(148, 163, 184, 0.25)',
                        'drawBorder' => false,
                    ],
                    'ticks' => [
                        'color' => '#475569',
                        'padding' => 8,
                        'font' => [
                            'size' => 12,
                        ],
                    ],
                ],
            ],
        ];
    }
}
