<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'author',
        'published_date',
        'synopsis',
        'isbn',
        'checked_in',
    ];
    protected $casts = [
        'checked_in' => 'boolean',
    ];
}
