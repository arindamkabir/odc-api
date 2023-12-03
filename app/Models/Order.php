<?php

namespace App\Models;

use App\Exceptions\ShippingAddressNotFoundException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const STATUSES = [
        'placed' => 'Placed',
        'paid' => 'Paid',
        'shipped' => 'Shipped',
        'delivered' => 'Delivered',
        'cancelled' => 'Cancelled',
        'returned' => 'Returned'
    ];

    const STATUS_COLORS = [
        'placed' => 'blue',
        'paid' => 'green',
        'shipped' => 'green',
        'delivered' => 'green',
        'cancelled' => 'red',
        'returned' => 'red'
    ];

    protected $with = [];

    protected $appends = ['status_color', 'status_for_humans'];

    protected function statusColor(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => Order::STATUS_COLORS[$attributes["status"]]
        );
    }

    protected function statusForHumans(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => Order::STATUSES[$attributes["status"]]
        );
    }

    public function getShippingAddressAttribute()
    {
        if (!$this->shipping->exists) throw new ShippingAddressNotFoundException("Shipping address not found for order.");
        return
            $this->shipping->line1 .
            (($this->shipping->line2) ? ', ' . $this->shipping->line2 : '') . ', ' .
            $this->shipping->city . ', ' .
            $this->shipping->state . ', ' .
            $this->shipping->country . ', ' .
            $this->shipping->zip_code;
    }

    public function getBillingAddressAttribute()
    {
        if (!$this->billing->exists) return $this->shipping_address;
        return
            $this->billing->line1 .
            (($this->billing->line2) ? ', ' . $this->billing->line2 : '') . ', ' .
            $this->billing->city . ', ' .
            $this->billing->state . ', ' .
            $this->billing->country . ', ' .
            $this->billing->zip_code;
    }

    public function getOrderedDateAttribute()
    {
        return $this->created_at?->format('Y-m-d');
    }


    // Relationships

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shipping()
    {
        return $this->hasOne(OrderAddress::class)->ofMany([
            'created_at' => 'max',
        ], function ($query) {
            $query->where('type', 'shipping');
        });
    }

    public function billing()
    {
        return $this->hasOne(OrderAddress::class)->ofMany([
            'created_at' => 'max',
        ], function ($query) {
            $query->where('type', 'billing');
        });
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class)->withDefault();
    }

    // Scopes
    public function scopeStatusNotPlaced($query)
    {
        $query->where('status', '!=', 'placed');
    }

    public function scopePaymentCompleted($query)
    {
        $query->whereIn('status', ['paid', 'shipped', 'delivered']);
    }

    public function scopeGroupByMonth(Builder $query)
    {
        return $query->selectRaw('month(created_at) as month')
            ->selectRaw('count(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();
    }

    public function scopeGroupByDay(Builder $query)
    {
        return $query->selectRaw('day(created_at) as day')
            ->selectRaw('count(*) as count')
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('count', 'day')
            ->toArray();
    }

    public function scopeInYear(Builder $query, $year)
    {
        return $query->whereYear('created_at', $year);
    }

    public function scopeInMonth(Builder $query, $month)
    {
        return $query->whereMonth('created_at', $month);
    }

    public function scopeSearch(Builder $query, $term): void
    {
        $query->whereHas('shipping', function (Builder $queryy) use ($term) {
            $queryy->where('phone', 'like', '%' . $term . '%');
        })->orWhereHas('order_items', function (Builder $query2) use ($term) {
            $query2->whereHas('stock', function (Builder $query3) use ($term) {
                $query3->whereHas('product', function (Builder $query4) use ($term) {
                    $query4->where("name", 'like', '%' . $term . '%');
                });
            });
        });
    }
}
