<?php

namespace MLL\LaravelDbReady;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Connection;

class DbReadyCommand extends Command
{
    const SUCCESS = 'Successfully established a connection.';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '
        db:ready
        {--database= : The database connection to use}
        {--timeout=5 : Time in seconds that connecting should be attempted}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Wait until a database connection is ready.';

    /**
     * Execute the console command.
     *
     * @throws \Exception
     */
    public function handle(/*ConnectionResolverInterface $connectionResolver*/): void
    {
        $this->info('Waiting for a successful database connection...');

        $timeout = $this->option('timeout');
        $this->output->progressStart($timeout);

        /** @var Connection $connection */
        $connection = DB::connection(
            $this->option('database')
        );

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
        } while (empty($result));

        $this->output->progressFinish();
        $this->info(self::SUCCESS);
    }
}
