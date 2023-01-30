<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MonthlyInvoice extends Mailable
{
    use Queueable, SerializesModels;

    public $billing;

    public function __construct($billing)
    {
        $this->billing = $billing;
    }

    public function build()
    {
        return $this->from('system@tripbd.com', 'System')->subject('Monthly Invoice')->view('billing.invoice')->with(['data' => $this->billing]);
    }
}
