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

class ShieldingPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
                   ->id('shielding')
                   ->path('shielding')
            ->viteTheme('resources/css/filament/shielding/theme.css')
                   ->colors([
                       'primary' => Color::Amber,
                   ])
                   ->discoverResources(in: app_path('Filament/Shielding/Resources'), for: 'App\Filament\Shielding\Resources')
                   ->discoverPages(in: app_path('Filament/Shielding/Pages'), for: 'App\Filament\Shielding\Pages')
                   ->pages([
                       Dashboard::class,
                   ])
                   ->discoverWidgets(in: app_path('Filament/Shielding/Widgets'), for: 'App\Filament\Shielding\Widgets')
                   ->widgets([
                   ])
                   ->navigationItems([
                       NavigationItem::make('RadDB Dashboard')
                           ->url('/')
                           ->icon(Heroicon::OutlinedPresentationChartBar)
                           ->sort(1),
                       NavigationItem::make('Survey Schedule')
                           ->url('/raddb/survey-schedule-views')
                           ->icon(Heroicon::OutlinedHome)
                           ->sort(1),
                       NavigationItem::make('RadDB')
                           ->url('/raddb')
                           ->icon(Heroicon::OutlinedHome)
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
                   ->authMiddleware([]);
    }
}
