<?php

namespace App\Filament\Widgets;

use App\Models\Arsip;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class DocTypeDistributionChart extends ChartWidget
{
    protected static ?string $heading = 'Distribusi Tipe Dokumen';
    protected int|string|array $columnSpan = 1;
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
        // Ambil ekstensi dari original_file_name bila ada, fallback ke file_path
        $rows = Arsip::query()
            ->selectRaw("LOWER(NULLIF(NULLIF(SUBSTRING_INDEX(original_file_name, '.', -1), ''), NULL)) as ext")
            ->selectRaw('COUNT(*) as total')
            ->groupBy('ext')
            ->orderByDesc('total')
            ->get();

        // Fallback untuk record tanpa ext di original_file_name
        if ($rows->where('ext', null)->sum('total') > 0) {
            $fallback = Arsip::query()
                ->selectRaw("LOWER(NULLIF(NULLIF(SUBSTRING_INDEX(file_path, '.', -1), ''), NULL)) as ext")
                ->selectRaw('COUNT(*) as total')
                ->groupBy('ext')
                ->orderByDesc('total')
                ->get();
            // Gabungkan hasil fallback
            $map = [];
            foreach ($rows as $r) { $map[$r->ext] = ($map[$r->ext] ?? 0) + (int)$r->total; }
            foreach ($fallback as $r) { $map[$r->ext] = ($map[$r->ext] ?? 0) + (int)$r->total; }
            ksort($map);
            $labels = array_map(fn($e) => strtoupper($e ?: 'LAINNYA'), array_keys($map));
            $values = array_values($map);
        } else {
            $labels = $rows->pluck('ext')->map(fn($e) => strtoupper($e ?: 'LAINNYA'))->toArray();
            $values = $rows->pluck('total')->toArray();
        }

        $colors = ['#0EA5E9','#22C55E','#F59E0B','#6366F1','#EF4444','#14B8A6','#8B5CF6','#F97316','#06B6D4','#84CC16'];

        return [
            'labels' => $labels,
            'datasets' => [[
                'data' => $values,
                'backgroundColor' => array_slice($colors, 0, count($labels)),
                'borderColor' => '#ffffff', 'borderWidth' => 2, 'hoverOffset' => 6,
            ]],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'events' => ['mousemove','mouseout','click','touchstart','touchmove','touchend'],
            'interaction' => ['mode' => 'index', 'intersect' => false],
            // 'plugins' => [
            //     'legend' => ['position' => 'right', 'labels' => ['usePointStyle' => true]],
            //     'tooltip' => [
            //         'enabled' => true,
            //         'callbacks' => [
            //             'label' => new \Illuminate\Support\Js(<<<'JS'
            //                 function(ctx){
            //                     const label = ctx.label || '';
            //                     const v = ctx.parsed ?? ctx.raw ?? 0;
            //                     const data = ctx.dataset?.data || [];
            //                     const total = data.reduce((a,b)=>a + (typeof b==='number'? b:0),0);
            //                     const pct = total>0 ? ` (${(v*100/total).toFixed(1)}%)` : '';
            //                     try { return `${label}: ${new Intl.NumberFormat('id-ID').format(v)} arsip${pct}`; }
            //                     catch { return `${label}: ${v} arsip${pct}`; }
            //                 }
            //             JS),
            //         ],
            //     ],
            // ],
            'cutout' => '60%',
        ];
    }
}
