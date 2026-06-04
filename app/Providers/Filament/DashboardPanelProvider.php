<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class DashboardPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
                   ->default()
                   ->id('dashboard')
                   ->path('')
            ->viteTheme('resources/css/filament/dashboard/theme.css')
                   ->brandName('RadDB Filament')
                   // ->login()
                   ->colors([
                       'primary' => Color::Amber,
                   ])
                   ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
                   ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
                   ->pages([
                       Dashboard::class,
                   ])
                   ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
                   ->widgets([
                   ])
                   ->navigationItems([
                       NavigationItem::make('Survey Schedule')
                           ->url('/raddb/survey-schedule-views')
                           ->icon(Heroicon::OutlinedHome)
                           ->sort(1),
                       NavigationItem::make('RadDB')
                           ->url('/raddb')
                           ->icon(Heroicon::OutlinedHome)
                           ->sort(1),
                       NavigationItem::make('Shielding Requests')
                           ->url('/shielding')
                           ->icon(Heroicon::OutlinedShieldCheck)
                           ->sort(1),
                   ])
                   ->middleware([
                       EncryptCookies::class,
                       AddQueuedCookiesToResponse::class,
                       StartSession::class,
                       AuthenticateSession::class,
                       ShareErrorsFromSession::class,
                       PreventRequestForgery::class,
                       SubstituteBindings::class,
                       DisableBladeIconComponents::class,
                       DispatchServingFilamentEvent::class,
                   ])
                   ->authMiddleware([
                   ]);
    }
}
