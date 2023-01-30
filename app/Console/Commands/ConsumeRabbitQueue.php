<?php

namespace App\Console\Commands;

use App\Mail\TripOrder;
use App\Models\User;
use Bschmitt\Amqp\Amqp;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ConsumeRabbitQueue extends Command
{
    protected $signature = 'rabbit:queue';

    protected $description = 'Consume rabbitmq queue';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Amqp::consume(
            'send-trip-mail-everyone',
            function ($message, $resolver) {

                $emails = User::pluck('email');
                if (!empty($emails)) {
                    $payload = json_decode($message->body);
                    foreach ($emails as $email) {
                        Mail::to($email)->send(new TripOrder($payload));
                    }
                }

                $resolver->acknowledge($message);
                $resolver->stopWhenProcessed();
            }
        );
    }
}
