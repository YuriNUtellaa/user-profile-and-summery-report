<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['user_id', 'slot_id', 'start_time', 'end_time'];

    // Define relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }

    // Method to set start and end times automatically
    public function setStartAndEndTime()
    {
        $this->start_time = now();
        $this->end_time = now()->addHours(config('reservation.duration_hours')); // Assuming duration_hours is defined in your config
    }

}

