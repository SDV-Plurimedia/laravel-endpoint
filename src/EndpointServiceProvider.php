<?php

namespace Fab\Endpoint;

use Illuminate\Support\ServiceProvider;

class EndpointServiceProvider extends ServiceProvider
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
                Console\MakeControllerCommand::class,
                Console\MakeRepositoryCommand::class,
                Console\MakeTransformerCommand::class,
            ]);
        }

        $this->registerFractal();
    }

    protected function registerFractal()
    {
        $this->app->register(\Spatie\Fractal\FractalServiceProvider::class);
    }
}
