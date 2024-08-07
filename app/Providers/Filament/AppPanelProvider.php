<?php

namespace App\Providers\Filament;

use App\Filament\App\Pages\Auth\EditProfile;
use App\Filament\App\Pages\Auth\Login;
use App\Filament\App\Pages\Auth\Register;
use App\Filament\App\Pages\RegisterStore;
use App\Filament\App\Widgets\StatsOverview;
use App\Models\Store\Store;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('app')
            ->path('')
            ->spa()
            ->login(Login::class)
            ->registration(Register::class)
            ->passwordReset()
            ->profile(EditProfile::class)
            ->darkMode(false)
            ->tenant(Store::class)
            ->tenantRegistration(RegisterStore::class)
            ->domain('app.' . parse_url(config('app.url'))['host'])
            ->brandName('Shoptoner')
            ->colors([
                'primary' => "#E74946",
            ])
            ->discoverResources(in: app_path('Filament/App/Resources'), for: 'App\\Filament\\App\\Resources')
            ->discoverPages(in: app_path('Filament/App/Pages'), for: 'App\\Filament\\App\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/App/Widgets'), for: 'App\\Filament\\App\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                StatsOverview::class,
            ])
            ->renderHook(
                PanelsRenderHook::BODY_END,
                fn (): string => Blade::render('<script src="https://telegram.org/js/telegram-web-app.js"></script>'),
            )
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->viteTheme('resources/css/filament/app/theme.css');
    }
}
