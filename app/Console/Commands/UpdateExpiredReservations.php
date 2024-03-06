<?php

namespace App\Console\Commands;

use App\Models\Slot;
use App\Models\Reservation;
use Illuminate\Console\Command;

class UpdateExpiredReservations extends Command
{
    protected $signature = 'reservations:update-expired';

    protected $description = 'Update the status of slots with expired reservations';

    public function handle()
    {
        $expiredReservations = Reservation::where('end_time', '<=', now())->get();

        foreach ($expiredReservations as $reservation) {
            $slot = Slot::find($reservation->slot_id);
            $slot->status = 'available';
            $slot->save();
        }

        $this->info('Expired reservations processed successfully.');
    }
    
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    /**
     * The console command description.
     *
     * @var string
     */

    /**
     * Execute the console command.
     */

}
