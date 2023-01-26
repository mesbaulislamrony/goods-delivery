<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

//use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'from',
        'to',
        'transporter_id',
        'status',
        'date',
        'amount',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function transporter()
    {
        return $this->belongsTo(User::class, 'transporter_id', '_id');
    }

    public function goods()
    {
        return $this->hasMany(UserTripGood::class, 'trip_id', '_id');
    }
}
