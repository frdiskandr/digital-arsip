<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \App\Models\Arsip::class => \App\Policies\ArsipPolicy::class,
        \App\Models\Kategori::class => \App\Policies\KategoriPolicy::class,
        \App\Models\Picture::class => \App\Policies\PicturePolicy::class,
        \App\Models\Setting::class => \App\Policies\SettingPolicy::class,
        \App\Models\AuditLog::class => \App\Policies\AuditLogPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
