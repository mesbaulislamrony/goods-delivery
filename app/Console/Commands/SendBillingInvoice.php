<?php

namespace App\Console\Commands;

use App\Jobs\MonthlyInvoiceJob;
use App\Mail\MonthlyInvoice;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

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
        $users = User::with('billing')->get();
        if (!empty($users)) {
            foreach ($users as $user) {
                MonthlyInvoiceJob::dispatch($user)->onQueue('monthly-invoice');
            }
        }
    }
}
