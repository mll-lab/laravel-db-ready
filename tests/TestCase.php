<?php

namespace Tests;

use MLL\LaravelDbReady\LaravelDbReadyServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            LaravelDbReadyServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $config = $this->databaseConfig();

        $app['config']->set('database.default', $config['driver']);
        $app['config']->set('database.connections.'.$config['driver'], $config);
    }

    abstract protected function databaseConfig(): array;
}
