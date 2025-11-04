<?php

namespace App\Filament\Widgets;

use App\Models\Arsip;
use App\Models\Kategori;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ArsipStatsOverview extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 3;


    protected function getStats(): array
    {
        // Build simple sparkline series for the last 8 months (including current month)
        $months = 8;
        $arsipSeries = Cache::remember(
            "stats:arsips:$months",
            now()->addMinutes(10),
            fn() =>
            $this->buildMonthlyCountSeries('arsips', 'created_at', $months)
        );
        $kategoriSeries = Cache::remember(
            "stats:kategoris:$months",
            now()->addMinutes(10),
            fn() =>
            $this->buildMonthlyCountSeries('kategoris', 'created_at', $months)
        );
        // For pengunggah, count distinct user_id in arsips per month
        $pengunggahSeries = Cache::remember(
            "stats:uploaders:$months",
            now()->addMinutes(10),
            fn() =>
            $this->buildMonthlyDistinctSeries('arsips', 'user_id', 'created_at', $months)
        );

        [$arsipDelta, $arsipUp] = $this->monthDelta($arsipSeries);
        [$kategoriDelta, $kategoriUp] = $this->monthDelta($kategoriSeries);
        [$pengunggahDelta, $pengunggahUp] = $this->monthDelta($pengunggahSeries);

        return [
            Card::make('Total Arsip', Arsip::count())
                ->description(($arsipUp ? '+' : '') . $arsipDelta . ' vs bulan lalu')
                ->descriptionIcon($arsipUp ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->icon('heroicon-o-archive-box')
                ->color('success')
                ->chart($arsipSeries),

            Card::make('Total Kategori', Kategori::count())
                ->description(($kategoriUp ? '+' : '') . $kategoriDelta . ' vs bulan lalu')
                ->descriptionIcon($kategoriUp ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->icon('heroicon-o-folder')
                ->color('info')
                ->chart($kategoriSeries),

            Card::make('Total Pengunggah', User::has('arsip')->count())
                ->description(($pengunggahUp ? '+' : '') . $pengunggahDelta . ' vs bulan lalu')
                ->descriptionIcon($pengunggahUp ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->icon('heroicon-o-user-group')
                ->color('warning')
                ->chart($pengunggahSeries),
        ];
    }

    /**
     * Build an array of monthly counts for the last N months (ascending order),
     * suitable for StatsOverview card sparkline charts.
     *
     * @param string $table Database table name
     * @param string $dateColumn Timestamp column name (e.g., created_at)
     * @param int $months Number of months to include (including current month)
     * @return array<int,int>
     */
    protected function buildMonthlyCountSeries(string $table, string $dateColumn, int $months = 8): array
    {
        $end = Carbon::now()->startOfMonth();
        $start = (clone $end)->copy()->subMonths($months - 1);

        $rows = DB::table($table)
            ->selectRaw('DATE_FORMAT(' . $dateColumn . ', "%Y-%m") as ym, COUNT(*) as total')
            ->whereBetween($dateColumn, [$start, (clone $end)->endOfMonth()])
            ->groupBy('ym')
            ->pluck('total', 'ym')
            ->toArray();

        // Build a zero-filled series, then overlay with actual counts
        $series = [];
        $cursor = $start->copy();
        while ($cursor <= $end) {
            $key = $cursor->format('Y-m');
            $series[] = (int)($rows[$key] ?? 0);
            $cursor->addMonth();
        }

        return $series;
    }

    /**
     * Build an array of distinct counts per month (e.g., distinct user_id) for the last N months.
     */
    protected function buildMonthlyDistinctSeries(string $table, string $distinctColumn, string $dateColumn, int $months = 8): array
    {
        $end = Carbon::now()->startOfMonth();
        $start = (clone $end)->copy()->subMonths($months - 1);

        $rows = DB::table($table)
            ->selectRaw('DATE_FORMAT(' . $dateColumn . ', "%Y-%m") as ym, COUNT(DISTINCT ' . $distinctColumn . ') as total')
            ->whereBetween($dateColumn, [$start, (clone $end)->endOfMonth()])
            ->groupBy('ym')
            ->pluck('total', 'ym')
            ->toArray();

        $series = [];
        $cursor = $start->copy();
        while ($cursor <= $end) {
            $key = $cursor->format('Y-m');
            $series[] = (int)($rows[$key] ?? 0);
            $cursor->addMonth();
        }

        return $series;
    }

    /**
     * Compute delta between last and previous month and whether it's trending up.
     * @param array<int,int> $series
     * @return array{int,bool}
     */
    protected function monthDelta(array $series): array
    {
        $n = count($series);
        if ($n < 2) {
            return [0, false];
        }
        $last = (int) $series[$n - 1];
        $prev = (int) $series[$n - 2];
        $delta = $last - $prev;
        return [$delta, $delta >= 0];
    }
}
