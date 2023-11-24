<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory;

    protected $with = ['stocks'];

    const STOCK_STATUSES = [
        'in_stock' => 'In Stock',
        'low_stock' => 'Low Stock',
        'out_of_stock' => 'Out Of Stock',
    ];

    const STOCK_STATUS_COLORS = [
        'in_stock' => 'bg-green-500',
        'low_stock' => 'bg-sky-500',
        'out_of_stock' => 'bg-red-500',
    ];

    protected $casts = [
        'on_sale' => 'boolean',
        'is_hidden' => 'boolean',
        'is_featured' => 'boolean'
        // 'has_colors' => 'boolean',
        // 'has_sizes' => 'boolean'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saving(function ($product) {
            if ($product->isDirty('name')) {
                $slug = Str::slug($product->name);
                $count = Product::where('id', '!=', $product->id)->whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count(); // check to see if any other slugs exist that are the same & count them
                $product->slug = $count ? "{$slug}-{$count}" : $slug; // if other slugs exist that are the same, append the count to the slug
            }
        });
    }


    public function hasColorSize($colorId, $sizeId)
    {
        if ($this->stocks()
            ->where('color_id', $colorId)
            ->where('size_id', $sizeId)
            ->where('quantity', '>', 0)
            ->exists()
        ) return true;

        return false;
    }

    // Accessor to get stock

    // *** Relationships ***

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function availableStocks(): HasMany
    {
        return $this->hasMany(Stock::class)->where('quantity', '>', 0);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function primaryImage(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable')->ofMany([
            'created_at' => 'max',
        ], function ($query) {
            $query->where('type', 'primary');
        });
    }

    public function secondaryImage(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable')->ofMany([
            'created_at' => 'max',
        ], function ($query) {
            $query->where('type', 'secondary');
        });
    }

    public function extraImages(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable')->whereNull('type');
    }

    // *** Scopes ***

    public function scopeOfCategory(Builder $query, $catId): void
    {
        $query->where('category_id', $catId);
    }

    public function scopeOfParentCategory(Builder $query, $catId): void
    {
        $query->whereHas('category', function (Builder $query) use ($catId) {
            $query->where('parent_id', $catId);
        });
    }

    public function scopeSearch(Builder $query, $term): void
    {
        $query->where("name", 'like', '%' . $term . '%');
    }
}
