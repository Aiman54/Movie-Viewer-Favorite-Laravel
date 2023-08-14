<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\DB;

class TestDatabaseConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
   

    /**
     * Execute the console command.
     */

    protected $signature = 'test:db-connection';
    protected $description = 'Test database connection';

    public function handle()
    {
        try {
            DB::connection()->getPdo();
            $this->info('Database connection is successful.');
        } catch (\Exception $e) {
            $this->error('Database connection failed: ' . $e->getMessage());
        }
    }
}
