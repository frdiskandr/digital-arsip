<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\HtmlString;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Provide compatibility aliases for packages that expect older Filament class locations.
        // Some third-party packages reference Get/Set under Filament\Schemas; newer Filament
        // exposes them under Filament\Forms. Create class aliases so both work.
        if (! class_exists('Filament\\Schemas\\Components\\Utilities\\Get') && class_exists(\Filament\Forms\Get::class)) {
            class_alias(\Filament\Forms\Get::class, 'Filament\\Schemas\\Components\\Utilities\\Get');
        }

        if (! class_exists('Filament\\Schemas\\Components\\Utilities\\Set') && class_exists(\Filament\Forms\Set::class)) {
            class_alias(\Filament\Forms\Set::class, 'Filament\\Schemas\\Components\\Utilities\\Set');
        }

        Schema::defaultStringLength(191);
        FilamentView::registerRenderHook(
            'panels::head.end',
            fn(): HtmlString => new HtmlString('<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
            '),
        );
    }
}
