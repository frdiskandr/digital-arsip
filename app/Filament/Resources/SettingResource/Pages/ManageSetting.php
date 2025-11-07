<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use App\Models\Setting;
use Filament\Resources\Pages\Page;

class ManageSetting extends Page
{
    protected static string $resource = SettingResource::class;

    protected static string $view = 'filament.resources.setting-resource.pages.manage-setting';

    public function mount(): void
    {
        // Ensure there is at least one settings row, then redirect to edit it
        $setting = Setting::first();

        if (! $setting) {
            $setting = Setting::create([]);
        }

        $this->redirect(SettingResource::getUrl('edit', ['record' => $setting->getKey()]));
    }
}
