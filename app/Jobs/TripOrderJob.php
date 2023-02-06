<?php

namespace App\Jobs;

use App\Mail\TripOrderMailable;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class TripOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $trip;

    public function __construct($trip)
    {
        $this->trip = $trip;
    }

    public function handle()
    {
        $emails = User::pluck('email');
        if (!empty($emails)) {
            $payload = json_decode($this->trip);
            foreach ($emails as $email) {
                Mail::to($email)->send(new TripOrderMailable($payload));
            }
        }
    }
}
