<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class EmailVerificationNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = url('/verify-email/' . $this->token);

        return (new \Illuminate\Notifications\Messages\MailMessage)
                ->subject('[Rese]メールアドレスのご確認')
                ->view('emails.verify_email', ['url' => $url]);
    }
}
