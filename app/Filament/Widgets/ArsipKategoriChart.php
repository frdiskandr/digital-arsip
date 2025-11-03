<?php

namespace App\Filament\Widgets;

use App\Models\Arsip;
use App\Models\Kategori;
use Filament\Widgets\ChartWidget;

class ArsipKategoriChart extends ChartWidget
{
    protected static ?string $heading = 'Distribusi Arsip per Kategori';
    protected int | string | array $columnSpan = 1;
    protected static ?int $sort = 2;

    public function getColumnSpan(): array|int|string
    {
        return 1;
    }


    protected function getData(): array
    {
        $data = Arsip::query()
            ->select('kategori_id')
            ->selectRaw('count(*) as total')
            ->groupBy('kategori_id')
            ->get();

        $labels = $data->map(function ($item) {
            return Kategori::find($item->kategori_id)->nama ?? 'Lainnya';
        });

        $colors = [
            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#E7E9ED',
            '#8D6E63', '#FFD54F', '#66BB6A', '#EF5350', '#AB47BC', '#26A69A', '#FFA726',
        ];

        return [
            'datasets' => [
                [
                    'label' => 'Arsip',
                    'data' => $data->pluck('total'),
                    'backgroundColor' => array_slice($colors, 0, count($labels)),
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
