<?php

namespace MLL\LaravelDbReady;

use Illuminate\Support\ServiceProvider;

class LaravelDbReadyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                DbReadyCommand::class,
            ]);
        }
    }
}
