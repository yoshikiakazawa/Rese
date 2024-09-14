<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Mail\ReservationReminder;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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
            if (!empty($reservation->user->email_verified_at)) {
                try {
                    Mail::to($reservation->user->email)->queue(new ReservationReminder($reservation));
                    Log::info('Reservation reminder sent to: ' . $reservation->user->email);
                } catch (\Exception $e) {
                    Log::error('Failed to send reservation reminder to: ' . $reservation->user->email . ' Error: ' . $e->getMessage());
                }
            }
        }

        return 0;
    }
}
