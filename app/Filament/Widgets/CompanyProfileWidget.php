<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class CompanyProfileWidget extends Widget
{
    protected static string $view = 'filament.widgets.company-profile-widget';
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 1;


}
