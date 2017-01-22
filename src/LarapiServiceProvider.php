<?php
namespace Fab\Larapi;

use Illuminate\Support\ServiceProvider;

class LarapiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
    }
    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\MakeEndpointCommand::class,
            ]);
        }

        $this->app->register(
            \Spatie\Fractal\FractalServiceProvider::class
        );
    }
}
