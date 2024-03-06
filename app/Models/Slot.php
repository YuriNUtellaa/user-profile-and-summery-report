<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    use HasFactory;

    public function currentReservation()
    {
        return $this->reservations()->where('end_time', '>=', now())->first();
    }


    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function currentRental()
    {
        return $this->rentals()->whereNull('end_time')->first();
    }

    public function rentals()
    {
        return $this->hasMany(SlotRental::class);
    }

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'slots';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['slot_number', 'status', 'start_time']; // Add start_time to fillable fields

    public function renter()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
