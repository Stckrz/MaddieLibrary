<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patron extends Model
{
    use HasFactory;
    protected $fillable = [
        'firstName',
        'lastName',
        'card_number',
        'email',
    ];
}

