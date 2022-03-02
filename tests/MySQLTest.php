<?php

namespace Tests;

use Illuminate\Testing\PendingCommand;
use MLL\LaravelDbReady\DbReadyCommand;

class MySQLTest extends TestCase
{
    protected function databaseConfig(): array
    {
        return [
            'driver' => 'mysql',
            'database' => 'test',
            'host' => env('GITHUB_ACTIONS') ? 'localhost' : 'mysql',
            'username' => 'root',
            'password' => 'root',
        ];
    }

    public function testSuccess(): void
    {
        $readyCommand = $this->artisan('db:ready');
        assert($readyCommand instanceof PendingCommand);
        $readyCommand
            ->expectsOutput(DbReadyCommand::SUCCESS)
            ->assertExitCode(0)
            ->run();
    }

    public function testFailure(): void
    {
        config(['database.connections.mysql.host' => 'non-existent']);

        $readyCommand = $this->artisan('db:ready --timeout=1');
        assert($readyCommand instanceof PendingCommand);

        $this->expectException(\Exception::class);
        $readyCommand->run();
    }

    public function testTimeoutString(): void
    {
        $readyCommand = $this->artisan('db:ready --timeout=not-a-valid-timeout');
        assert($readyCommand instanceof PendingCommand);

        $this->expectException(\InvalidArgumentException::class);
        $readyCommand->run();
    }
}
