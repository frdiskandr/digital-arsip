<?php

namespace App\Filament\Pages;

use Filament\Pages\Auth\EditProfile as BaseEditProfile;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Hash;

class Profile extends BaseEditProfile
{
    // Customize how this page appears in the Filament navigation
    protected static ?string $navigationLabel = 'Profil Saya';
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?int $navigationSort = 100;
    protected static ?string $navigationGroup = 'Pengaturan';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->schema([
                        Section::make('Informasi Profil')
                            ->description('Update informasi profil dan email akun Anda.')
                            ->icon('heroicon-o-identification')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nama')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Masukkan nama lengkap')
                                    ->prefixIcon('heroicon-m-user'),

                                TextInput::make('email')
                                    ->label('Email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->placeholder('contoh@email.com')
                                    ->prefixIcon('heroicon-m-envelope'),
                            ]),

                        Section::make('Update Password')
                            ->description('Pastikan menggunakan password yang kuat untuk keamanan akun Anda.')
                            ->icon('heroicon-o-key')
                            ->schema([
                                TextInput::make('password')
                                    ->label('Password Baru')
                                    ->password()
                                    ->revealable(filament()->arePasswordsRevealable())
                                    ->rule('min:8')
                                    ->placeholder('Minimal 8 karakter')
                                    ->prefixIcon('heroicon-m-lock-closed')
                                    ->dehydrated(fn($state) => filled($state))
                                    ->dehydrateStateUsing(fn($state) => Hash::make($state))
                                    ->live(debounce: 500)
                                    ->same('passwordConfirmation'),

                                TextInput::make('passwordConfirmation')
                                    ->label('Konfirmasi Password')
                                    ->password()
                                    ->revealable(filament()->arePasswordsRevealable())
                                    ->placeholder('Ketik ulang password baru')
                                    ->prefixIcon('heroicon-m-lock-closed')
                                    ->dehydrated(false)
                                    ->required(fn($get) => filled($get('password'))),
                            ])
                    ])
                    ->columns(1),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Perubahan')
                ->submit('save'),
        ];
    }
}
