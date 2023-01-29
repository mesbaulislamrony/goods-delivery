<?php

namespace App\Console\Commands;

use App\Models\Billing;
use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateDailyBilling extends Command
{
    protected $signature = 'generate:billing';

    protected $description = 'Generate daily bill for everyone';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $today = Carbon::today()->format('Y-m-d');
        $trips = Trip::selectRaw('sum(amount) as amount, transporter_id')->where(
            ['date' => $today]
        )->groupBy('transporter_id')->pluck('amount', 'transporter_id');

        if (!empty($trips)) {
            foreach ($trips as $key => $trip) {
                $array[] = [
                    'date' => $today,
                    'transporter_id' => $key,
                    'amount' => $trip,
                ];
            }
            Billing::whereIn('transporter_id', array_keys($trips->toArray()))->where(['date' => $today])->delete();
            Billing::insert($array);
        }
    }
}
