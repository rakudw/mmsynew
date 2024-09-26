<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\SMSHelper;

class TestSMSCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-sms';

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
        dump(SMSHelper::sendSMS('9418767724', 'NEW_OTP_MSG', [mt_rand(1000, 9999)]));
        return Command::SUCCESS;
    }
}
