<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'stock_id',
        'product_id',
        'price',
        'quantity',
    ];

    // protected $with = ['product'];

    // protected $appends = ['total'];

    // public function getTotalAttribute()
    // {
    //     return number_format($this->product->price * $this->quantity, 2);
    // }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    // Scopes
    public function scopeOrderPaymentCompleted($query)
    {
        // whereRelation('order', 'status', false)
        $query->whereHas('order', function ($q) {
            $q->whereIn('status', ['paid', 'shipped', 'delivered']);
        });
    }
}
