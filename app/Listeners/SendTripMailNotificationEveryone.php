<?php

namespace App\Listeners;

use App\Events\TripOrderEvent;
use App\Mail\TripOrderMailable as TripOrderMailer;
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

    public function handle(TripOrderEvent $event)
    {
        $emails = User::pluck('email');
        if (!empty($emails)) {
            foreach ($emails as $email) {
                Mail::to($email)->send(new TripOrderMailer(json_decode($event->trip)));
            }
        }
    }
}
