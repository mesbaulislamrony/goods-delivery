<?php

namespace App\Console;

use App\Jobs\SendBillingInvoice;
use App\Jobs\MonthlyInvoiceJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('generate:billing')->daily();
        $schedule->command('send:invoice')->monthly();
        $schedule->job(new MonthlyInvoiceJob, 'monthly-invoice', 'database')->monthlyOn(1, '15:00');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
