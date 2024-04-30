<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

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
        Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
            $event->extendSocialite('telegram', \SocialiteProviders\Telegram\Provider::class);
        });

        Relation::enforceMorphMap([
            'user' => 'App\Models\User',
            'store' => 'App\Models\Store\Store',
            'store-user' => 'App\Models\Store\StoreUser',
            'product' => 'App\Models\Product\Product',
            'payment' => 'App\Models\Payment\Payment',
            'payment-item' => 'App\Models\Payment\PaymentItem',
            'product-user' => 'App\Models\Product\ProductUser',
        ]);
    }
}
