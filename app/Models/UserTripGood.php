<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTripGood extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_id',
        'transporter_id',
        'name',
    ];
}
