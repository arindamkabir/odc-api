<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::saving(function ($color) {
            if ($color->isDirty('name')) {
                $slug = str($color->name)->slug();
                $count = Color::where('id', '!=', $color->id)->whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count(); // check to see if any other slugs exist that are the same & count them
                $color->slug = $count ? "{$slug}-{$count}" : $slug; // if other slugs exist that are the same, append the count to the slug
            }
        });
    }
}
