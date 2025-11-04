<?php

namespace App\Filament\Widgets;

use App\Models\Arsip;
use App\Models\Kategori;
use Filament\Widgets\ChartWidget;

class ArsipKategoriChart extends ChartWidget
{
    protected static ?string $heading = 'Distribusi Arsip per Kategori';
    protected static ?int $sort = 3;

    public function getColumnSpan(): int | string | array
    {
        return [
            'md' => 2,
            'lg' => 1,
        ];
    }


    protected function getData(): array
    {
        $data = Arsip::query()
            ->select('kategori_id')
            ->selectRaw('count(*) as total')
            ->groupBy('kategori_id')
            ->get();

        $categoryNames = Kategori::query()
            ->whereIn('id', $data->pluck('kategori_id')->filter()->unique())
            ->pluck('nama', 'id');

        $labels = $data->map(function ($item) use ($categoryNames) {
            return $categoryNames[$item->kategori_id] ?? 'Lainnya';
        })->values();

        $values = $data->pluck('total');

        $palette = \collect([
            '#3B82F6',
            '#0EA5E9',
            '#22C55E',
            '#FACC15',
            '#F97316',
            '#EF4444',
            '#A855F7',
            '#EC4899',
            '#14B8A6',
            '#94A3B8',
        ])->take($labels->count())->values()->all();

        return [
            'datasets' => [
                [
                    'label' => 'Arsip',
                    'data' => $values,
                    'backgroundColor' => $palette,
                    'borderColor' => array_fill(0, $labels->count(), '#FFFFFF'),
                    'borderWidth' => 2,
                    'hoverOffset' => 10,
                ],
            ],
            'labels' => $labels->all(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'cutout' => '65%',
            'layout' => [
                'padding' => [
                    'top' => 16,
                    'right' => 16,
                    'bottom' => 16,
                    'left' => 16,
                ],
            ],
            'animation' => [
                'animateRotate' => true,
                'animateScale' => true,
            ],
            'plugins' => [
                'legend' => [
                    'position' => 'right',
                    'align' => 'center',
                    'labels' => [
                        'usePointStyle' => true,
                        'pointStyle' => 'circle',
                        'padding' => 16,
                        'boxWidth' => 12,
                        'boxHeight' => 12,
                        'color' => '#1F2937',
                        'font' => [
                            'size' => 12,
                            'weight' => '500',
                        ],
                    ],
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
        ];
    }
}
