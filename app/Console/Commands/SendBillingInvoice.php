<?php

namespace App\Console\Commands;

use App\Services\SendEveryoneMonthlyInvoice;
use Illuminate\Console\Command;

class SendBillingInvoice extends Command
{
    protected $signature = 'send:invoice';

    protected $description = 'Send billing invoice everyone';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        SendEveryoneMonthlyInvoice::send();
    }
}
