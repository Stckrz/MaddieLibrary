<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class Distributable extends Model
{
    use HasFactory;
    protected $table = 'distributables';
    protected $fillable = [
        'title',
        'synopsis',
    ];
    protected $casts = [
    ];

    protected $appends = ['isCheckedOut'];

    //returns a checkout for this item, if it has not been checked in
    public function currentCheckout()
    {
        return $this->hasOne(Checkout::class, 'distributable_id', 'id');
    }

    //returns a bool value whether or not there is a checkout for this item, that has not been checked in
    public function getIsCheckedOutAttribute()
    {
        return $this->currentCheckout()->exists();
    }

}
