<?php

namespace App\Services;

use App\Models\Coupon;

class CouponService
{
    public function store(array $attributes): Coupon
    {
        $coupon = new Coupon;
        $coupon->code = $attributes['code'];
        $coupon->min_cart_value = $attributes['min_cart_value'];
        $coupon->value = $attributes['value'];
        $coupon->value_type = $attributes['value_type'];
        $coupon->max_value = $attributes['max_value'];
        $coupon->is_disabled = $attributes['is_disabled'];
        $coupon->redemptions = $attributes['redemptions'];
        $coupon->expiry_date = $attributes['expiry_date'];
        $coupon->save();

        return $coupon;
    }

    public function update(string $id, array $attributes): bool
    {
        $coupon = Coupon::query()
            ->findOrFail($id);
        $coupon->min_cart_value = $attributes['min_cart_value'];
        $coupon->value = $attributes['value'];
        $coupon->value_type = $attributes['value_type'];
        $coupon->max_value = $attributes['max_value'];
        $coupon->is_disabled = $attributes['is_disabled'];
        $coupon->redemptions = $attributes['redemptions'];
        $coupon->expiry_date = $attributes['expiry_date'];

        $saved = $coupon->save();

        return $saved;
    }

    public function delete(string $id): bool
    {
        $coupon = Coupon::query()
            ->findOrFail($id);

        return $coupon->delete();
    }
}
