<?php

namespace App\Filament\User\Pages;

use Filament\Pages\Page;

class UserProfile extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static string $view = 'filament.user.pages.user-profile';

    public static function getNavigationLabel(): string
    {
        return __('Profile Information');
    }
}
