<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Distributable
{
    use HasFactory;
    protected $fillable = [
        'title',
        'author',
        'published_date',
        'synopsis',
        'img_url',
        'thumbnail',
        'isbn',
        'checked_in',
    ];
    protected $casts = [
        'checked_in' => 'boolean',
    ];

    // Automatically sets the type for new Book instances.
    protected $attributes = [
        'type' => 'Book',
    ];

    // Add a global scope to ensure queries only return books.
    protected static function booted()
    {
        static::addGlobalScope('type', function (Builder $builder) {
            $builder->where('type', 'Book');
        });
    }
}
