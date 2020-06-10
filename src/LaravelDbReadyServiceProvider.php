<?php

namespace MLL\LaravelDbReady;

use Illuminate\Support\ServiceProvider;

class LaravelDbReadyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                DbReadyCommand::class,
            ]);
        }
    }
}
