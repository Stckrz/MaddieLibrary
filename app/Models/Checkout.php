<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;
    protected $fillable = [
        'patron_id',
        'distributable_id',
        'checked_out_at',
        'checked_in_at',
    ];

    //returns the related patron
    public function patron()
    {
        return $this->belongsTo(Patron::class);
    }

    //returns the related distributable
    public function distributable()
    {
        return $this->belongsTo(Distributable::class);
    }

    //This will delete the checkout upon being checked in
    public function checkIn()
    {
        $this->delete();
    }
}
