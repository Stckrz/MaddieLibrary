<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Game extends Distributable
{
    use HasFactory;
    protected $fillable = [
        'title',
        'synopsis',
        'img_url',
        'thumbnail',
        'platform',
        'release_date',
        'checked_in',
    ];
    protected $casts = [
        'checked_in' => 'boolean',
    ];

 // Automatically sets the type for new Book instances.
    protected $attributes = [
        'type' => 'Game',
    ];

    // Add a global scope to ensure queries only return games.
    protected static function booted()
    {
        static::addGlobalScope('type', function (Builder $builder) {
            $builder->where('type', 'Game');
        });
    }
}
