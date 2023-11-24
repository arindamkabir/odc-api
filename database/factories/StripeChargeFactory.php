<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class StripeChargeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_id' => Str::random(10),
            'charge_id' => Str::random(10),
            'charge_amount' => function (array $attributes) {
                $transaction = Transaction::find($attributes['transaction_id']);
                $order = Order::find($transaction->order_id);
                return $order->total;
            },
            'refunded' => false
        ];
    }
}
