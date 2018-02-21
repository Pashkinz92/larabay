<?php 

namespace Larabay;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client as GuzzleClient;
use Larabay\Contracts\QueriesPixabay;
use Larabay\LarabayService;

class LarabayServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Register a binding for Larabay that receives a Guzzle client
         * with its base uri set to the base Pixabay API endpoint.
         * 
         * @see https://laravel.com/docs/5.6/container#contextual-binding
         */
        $this->app->when(LarabayService::class)
            ->needs(GuzzleClient::class)
            ->give(function () {
                return new GuzzleClient(['base_uri' => 'https://pixabay.com/api/']);
            });

        /**
         * Bind the LarabayService to the QueriesPixabay.
         * 
         * @see https://laravel.com/docs/5.6/container#binding-interfaces-to-implementations
         */
        $this->app->bind(QueriesPixabay::class, LarabayService::class);

        /**
         * Register the Larabay singleton.
         * 
         * @see https://laravel.com/docs/5.6/container#binding-basics
         */
        $this->app->singleton('larabay', function ($app) {
            return $app->make(LarabayService::class);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/larabay.php' => config_path('larabay.php'),
        ]);

        $this->mergeConfigFrom(
            __DIR__ . '/config/larabay.php', 'larabay'
        );
    }
}
