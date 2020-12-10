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
        /** @var \Illuminate\Testing\PendingCommand $readyCommand */
        $readyCommand = $this->artisan('db:ready');
        $readyCommand
            ->expectsOutput(DbReadyCommand::SUCCESS)
            ->assertExitCode(0)
            ->run();
    }

    public function testFailure(): void
    {
        config(['database.connections.mysql.host' => 'non-existent']);

        $this->expectException(\Exception::class);
        /** @var \Illuminate\Testing\PendingCommand $readyCommand */
        $readyCommand = $this->artisan('db:ready --timeout=1');
        $readyCommand->run();
    }

    public function testTimeoutString(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        /** @var \Illuminate\Testing\PendingCommand $readyCommand */
        $readyCommand = $this->artisan('db:ready --timeout=not-a-valid-timeout');
        $readyCommand->run();
    }
}
