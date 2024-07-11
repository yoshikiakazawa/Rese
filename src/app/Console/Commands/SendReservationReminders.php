<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Mail\ReservationReminder;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendReservationReminders extends Command
{
    protected $signature = 'reminders:send';
    protected $description = 'Send reservation reminders';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $reservations = Reservation::with('users','shops')->whereDate('date', Carbon::today())->get();
        foreach ($reservations as $reservation) {
            Mail::to($reservation->users->email)->send(new ReservationReminder($reservation));
        }

        return 0;
    }
}
