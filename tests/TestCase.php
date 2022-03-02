<?php

namespace Tests;

use MLL\LaravelDbReady\LaravelDbReadyServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * @return array<int, class-string<\Illuminate\Support\ServiceProvider>>
     */
    protected function getPackageProviders($app): array
    {
        return [
            LaravelDbReadyServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        parent::getEnvironmentSetUp($app);

        $databaseConfig = $this->databaseConfig();

        /** @var \Illuminate\Config\Repository $config */
        $config = $app['config'];
        $config->set('database.default', $databaseConfig['driver']);
        $config->set('database.connections.'.$databaseConfig['driver'], $databaseConfig);
    }

    /**
     * @return array<string, string>
     */
    abstract protected function databaseConfig(): array;
}
