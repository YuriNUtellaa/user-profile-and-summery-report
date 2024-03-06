<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlotRental extends Model
{
    use HasFactory;

    protected $fillable = [
        'slot_id',
        'start_time',
        'end_time',
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //bagoto
    public function slot()
{
    return $this->belongsTo(Slot::class, 'slot_id');
}
}
