<?php

namespace App\Services;

use App\Mail\MonthlyInvoice;
use App\Models\Billing;
use App\Models\Trip;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class SendEveryoneMonthlyInvoice
{
    public static function send()
    {
        $users = User::all();
        if (!empty($users)) {
            foreach ($users as $user) {
                Mail::to($user->email)->send(new MonthlyInvoice($user->billing));
            }
        }
    }
}
