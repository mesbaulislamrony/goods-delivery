<?php

namespace App\Mail;

use App\Models\Billing;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TripBilling extends Mailable
{
    use Queueable, SerializesModels;

    public $billing;

    public function __construct(Billing $billing)
    {
        $this->billing = $billing;
    }

    public function build()
    {
        return $this->from('billing@tripbd.com', 'Billing')->view('billing.invoice');
    }
}
