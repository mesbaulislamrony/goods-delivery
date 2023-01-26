<?php

namespace App\Mail;

use App\Models\Trip;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TripOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $trip;

    public function __construct(Trip $trip)
    {
        $this->trip = $trip;
    }

    public function build()
    {
        return $this->from('system@tripbd.com', 'Trip Order')->view('trip.order')->with(['data' => $this->trip]);
    }
}
