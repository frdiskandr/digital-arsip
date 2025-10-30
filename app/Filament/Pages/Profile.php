<?php

namespace App\Filament\Pages;

use Filament\Pages\Auth\EditProfile as BaseEditProfile;

class Profile extends BaseEditProfile
{
    // Customize how this page appears in the Filament navigation
    protected static ?string $navigationLabel = 'Profil Saya';
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?int $navigationSort = 100;

    // You can optionally group navigation items
    // protected static ?string $navigationGroup = 'Akun';
}
