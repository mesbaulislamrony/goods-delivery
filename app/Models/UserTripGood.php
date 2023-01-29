<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Jenssegers\Mongodb\Eloquent\Model;

use Illuminate\Database\Eloquent\Model;

class UserTripGood extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_id',
        'transporter_id',
        'name',
    ];

    protected $dates = ['created_at', 'updated_at'];
}
