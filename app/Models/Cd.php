<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cd extends Distributable
{
    use HasFactory;
    protected $fillable = [
        'title',
        'artist',
        'release_date',
        'synopsis',
        'checked_in',
    ];
    protected $casts = [
        'checked_in' => 'boolean',
    ];

    protected $attributes = [
        'type' => 'Cd',
    ];

    // Add a global scope to ensure queries only return games.
    protected static function booted()
    {
        static::addGlobalScope('type', function (Builder $builder) {
            $builder->where('type', 'Cd');
        });
    }
}
