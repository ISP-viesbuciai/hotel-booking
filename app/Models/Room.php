<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';
    protected $fillable = [
        'room_number',
        'type',
        'capacity',
        'price_per_night',
        'is_available',
        'floor',
        'connecting_room_number',
        'sea_view',
        'last_cleaned'
    ];
}
