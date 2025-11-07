<?php

namespace App\Filament\Widgets;

use App\Models\Arsip;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class DocTypeDistributionChart extends ChartWidget
{
    protected static ?string $heading = 'Distribusi Tipe Dokumen';
    protected int|string|array $columnSpan = [
        'md' => 2,
        'lg' => 1,
    ];
    protected static ?int $sort = 2;

    protected function getType(): string
    {
        return 'doughnut';
    }

    // protected function getMaxHeight(): string|null
    // {
    //     return '300px';
    // }

    protected function getData(): array
    {
        // Ambil ekstensi dari original_file_name bila ada, fallback ke file_path bila kosong
        $rows = Arsip::query()
            ->selectRaw("LOWER(NULLIF(NULLIF(SUBSTRING_INDEX(original_file_name, '.', -1), ''), NULL)) as ext")
            ->selectRaw('COUNT(*) as total')
            ->groupBy('ext')
            ->orderByDesc('total')
            ->get();

        $map = $rows->pluck('total', 'ext')->map(fn($count) => (int) $count)->all();

        if ($rows->whereNull('ext')->sum('total') > 0) {
            $fallback = Arsip::query()
                ->selectRaw("LOWER(NULLIF(NULLIF(SUBSTRING_INDEX(file_path, '.', -1), ''), NULL)) as ext")
                ->selectRaw('COUNT(*) as total')
                ->groupBy('ext')
                ->orderByDesc('total')
                ->get();

            foreach ($fallback as $row) {
                $key = $row->ext;
                $map[$key] = ($map[$key] ?? 0) + (int) $row->total;
            }

            ksort($map);
        }

        $labels = collect($map)
            ->keys()
            ->map(fn($ext) => strtoupper($ext ?: 'LAINNYA'))
            ->values();

        $values = collect($map)->values();

        $baseColors = [
            '#2563EB',
            '#0EA5E9',
            '#22C55E',
            '#FACC15',
            '#F97316',
            '#EF4444',
            '#A855F7',
            '#EC4899',
            '#14B8A6',
            '#64748B',
            '#6366F1',
            '#FB7185',
        ];

        $colorCount = max(count($baseColors), 1);

        $palette = $labels->map(function ($label, $index) use ($baseColors, $colorCount) {
            return $baseColors[$index % $colorCount];
        })->all();

        return [
            'labels' => $labels->all(),
            'datasets' => [[
                'data' => $values->all(),
                'backgroundColor' => $palette,
                'borderColor' => array_fill(0, $labels->count(), '#FFFFFF'),
                'borderWidth' => 2,
                'hoverOffset' => 12,
            ]],
        ];
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
