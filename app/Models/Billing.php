<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

//use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'transporter_id',
        'amount',
    ];

    public function transporter()
    {
        return $this->belongsTo(User::class, 'transporter_id', '_id');
    }
}
