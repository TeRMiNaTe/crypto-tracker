<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use codenixsv\Bitfinex\BitfinexManager;
use codenixsv\Bitfinex\Clients\BitfinexClient;

class BitfinexServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(BitfinexClient::class, function ($app) {
            $manager = new BitfinexManager();

            return $manager->createClient();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
