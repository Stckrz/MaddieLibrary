<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Show extends Distributable
{
    use HasFactory;
    protected $fillable = [
        'title',
        'release_date',
        'synopsis',
        'img_url',
        'thumbnail',
        'checked_in',
    ];
    protected $casts = [
        'checked_in' => 'boolean',
    ];

    protected $attributes = [
        'type' => 'Show',
    ];

    // Add a global scope to ensure queries only return movies.
    protected static function booted()
    {
        static::addGlobalScope('type', function (Builder $builder) {
            $builder->where('type', 'Show');
        });
    }
}
