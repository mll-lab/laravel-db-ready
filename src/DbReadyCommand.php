<?php

namespace MLL\LaravelDbReady;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DbReadyCommand extends Command
{
    const SUCCESS = 'Successfully established a connection.';

    protected $signature = '
        db:ready
        {--database= : The database connection to use}
        {--timeout=30 : Time in seconds that connecting should be attempted}
    ';

    protected $description = 'Wait until a database connection is ready.';

    public function handle(): void
    {
        $this->info('Waiting for a successful database connection...');

        $timeout = $this->option('timeout');
        if (! is_numeric($timeout)) {
            throw new \InvalidArgumentException('Must pass an integer to option: timeout');
        }
        $timeout = (int) $timeout; // @phpstan-ignore-line This cast is fine, we checked that $timeout is numeric
        $this->output->progressStart($timeout);

        /** @var string|null $database */
        $database = $this->option('database');

        /** @var \Illuminate\Database\Connection $connection */
        $connection = DB::connection($database);

        do {
            try {
                $result = $connection->statement('SELECT TRUE;');
            } catch (\Exception $e) {
                $timeout--;
                // Once we timeout, we rethrow to enable diagnosing the issue
                if ($timeout <= 0) {
                    throw $e;
                }

                sleep(1);
                $this->output->progressAdvance();
            }
        } while (! isset($result));

        $this->output->progressFinish();
        $this->info(self::SUCCESS);
    }
}
