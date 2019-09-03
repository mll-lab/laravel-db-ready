<?php

namespace Tests;

use MLL\LaravelDbReady\DbReadyCommand;

class MySQLTest extends TestCase
{
    protected function databaseConfig(): array
    {
        return [
            'driver' => 'mysql',
            'database' => 'test',
            'host' => env('TRAVIS') ? '127.0.0.1' : 'mysql',
            'username' => 'root',
        ];
    }

    public function testSuccess(): void
    {
        $this->artisan('db:ready')
            ->expectsOutput(DbReadyCommand::SUCCESS)
            ->assertExitCode(0)
            ->run();
    }

    public function testFailure(): void
    {
        config(['database.connections.mysql.host' => 'non-existent']);

        $this->expectException(\Exception::class);
        $this->artisan('db:ready --timeout=1')->run();
    }
}
