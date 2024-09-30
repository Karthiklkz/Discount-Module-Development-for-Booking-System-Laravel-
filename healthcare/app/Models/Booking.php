<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    // Disable timestamps
    public $timestamps = false;

    // Define your fillable properties or other model properties
    protected $fillable = [
        'user_id',
        'doctor_id',
        'appointment_date',
        'original_cost',
        'final_cost',
        'discount_id',
    ];
}

