<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    protected $cast = [
        'is_hidden' => 'boolean',
        'is_featured' => 'boolean'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saving(function ($category) {
            if ($category->isDirty('name')) {
                $slug = Str::slug($category->name);
                $count = Category::where('id', '!=', $category->id)->whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count(); // check to see if any other slugs exist that are the same & count them
                $category->slug = $count ? "{$slug}-{$count}" : $slug; // if other slugs exist that are the same, append the count to the slug
            }
        });
    }


    // *** Attributes ***

    public function getIsParentAttribute(): bool
    {
        return $this->parent_id ? false : true;
    }

    public function getNameWithParent(): string
    {
        if (!$this->parent_id)
            return $this->name;

        return $this->parent->name . ' - ' . $this->name;
    }

    // *** Relationship ***

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // *** Scopes ***

    public function scopeParents($query)
    {
        $query->whereNull('parent_id');
    }

    public function scopeChildren($query)
    {
        $query->whereNotNull('parent_id');
    }

    public function scopeNotHidden($query)
    {
        $query->where('is_hidden', false);
    }

    public function scopeSearch($query, $term)
    {
        $query->where("name", 'like', '%' . $term . '%');
    }
}
