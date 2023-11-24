<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['url', 'type'];

    protected $appends =  ['full_url', 'storage_path'];

    public function getFullUrlAttribute()
    {
        return asset('storage/' . $this->url);
    }

    public function getStoragePathAttribute()
    {
        return storage_path('app/public/' . $this->url);
    }

    /**
     * Relationships
     */
    public function imageable()
    {
        return $this->morphTo();
    }

    /**
     *  Scopes
     */
    public function scopePrimary($query)
    {
        $query->where('type', 'primary');
    }

    public function scopeSecondary($query)
    {
        $query->where('type', 'secondary');
    }
}
