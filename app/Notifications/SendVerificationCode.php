<?php

namespace App\Notifications;

use App\Mail\SendVerificationCodeMailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendVerificationCode extends Notification implements ShouldQueue
{
    use Queueable;

    public $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new SendVerificationCodeMailable($this->code))->to($notifiable->email);
    }

    public function toArray($notifiable)
    {
        //
    }
}
