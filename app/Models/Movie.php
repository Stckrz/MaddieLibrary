<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movie extends Distributable
{
    use HasFactory;
    protected $fillable = [
        'title',
        'platform',
        'release_date',
        'synopsis',
        'checked_in',
    ];
    protected $casts = [
        'checked_in' => 'boolean',
    ];

    protected $attributes = [
        'type' => 'Movie',
    ];

    // Add a global scope to ensure queries only return movies.
    protected static function booted()
    {
        static::addGlobalScope('type', function (Builder $builder) {
            $builder->where('type', 'Movie');
        });
    }
}
