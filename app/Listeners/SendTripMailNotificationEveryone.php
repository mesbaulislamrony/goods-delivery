<?php

namespace App\Listeners;

use App\Events\TripOrder;
use App\Mail\TripOrder as TripOrderMailer;
use App\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendTripMailNotificationEveryone
{
    use InteractsWithQueue;

    public function __construct()
    {
        //
    }

    public function handle(TripOrder $event)
    {
        $emails = User::pluck('email');
        if (!empty($emails)) {
            foreach ($emails as $email) {
                Mail::to($email)->send(new TripOrderMailer(json_decode($event->trip)));
            }
        }
    }
}
