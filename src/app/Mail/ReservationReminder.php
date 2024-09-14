<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $shop;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reservation)
    {
        $this->reservation = $reservation;
        $this->shop = $reservation->shop;
        $this->user = $reservation->user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.reservation_reminder')
                    ->with([
                        'reservationDate' => $this->reservation->date,
                        'reservationTime' => $this->reservation->time,
                        'reservationShop' => $this->shop->shop_name,
                        'customerName' => $this->user->name,
                    ]);
    }
}
