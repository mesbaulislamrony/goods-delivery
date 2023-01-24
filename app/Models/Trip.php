<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'from',
        'to',
        'transporter_id',
        'status',
        'date',
    ];

    public function transporter()
    {
        return $this->belongsTo(User::class, 'transporter_id', 'id');
    }

    public function goods()
    {
        return $this->hasMany(UserTripGood::class, 'trip_id', 'id');
    }
}
