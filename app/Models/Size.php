<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::saving(function ($size) {
            if ($size->isDirty('name')) {
                $slug = str($size->name)->slug();
                $count = Size::where('id', '!=', $size->id)->whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count(); // check to see if any other slugs exist that are the same & count them
                $size->slug = $count ? "{$slug}-{$count}" : $slug; // if other slugs exist that are the same, append the count to the slug
            }
        });
    }
}
