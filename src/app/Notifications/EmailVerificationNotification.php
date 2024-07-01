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

        return (new MailMessage)
                    ->subject('Verify Your Email Address')
                    ->line('以下のボタンをクリックして、メールアドレスを確認してください。')
                    ->action('Verify Email', $url)
                    ->line('このメールに心当たりがない場合は、無視してください。');
    }
}
