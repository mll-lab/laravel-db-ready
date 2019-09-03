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

        $databaseConfig = $this->databaseConfig();

        /** @var \Illuminate\Config\Repository $config */
        $config = $app['config'];
        $config->set('database.default', $databaseConfig['driver']);
        $config->set('database.connections.'.$databaseConfig['driver'], $databaseConfig);
    }

    abstract protected function databaseConfig(): array;
}
