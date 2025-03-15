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
        'checked_in',
    ];
    protected $casts = [
        'checked_in' => 'boolean',
    ];
}
