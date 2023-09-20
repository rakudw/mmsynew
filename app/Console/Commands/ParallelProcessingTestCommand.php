<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Amp\Promise;

use function Amp\ParallelFunctions\parallelMap;

class ParallelProcessingTestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $values =Promise\wait(parallelMap([1, 2, 3], function ($time) {
            sleep($time);
            return $time * $time;
        }));
        dump($values);
        return Command::SUCCESS;
    }
}
