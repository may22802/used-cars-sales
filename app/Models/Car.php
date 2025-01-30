<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'user_id',
        'brand',
        'model',
        'country',
        'fuel',
        'year',
        'price',
        'meter_usage',
        'status',
    ];

    public function photos()
    {
        return $this->hasMany(CarPhoto::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }


    public function approved_bid()
    {
        return $this->hasOne(Bid::class)->where('status', 'approved');
    }
}
