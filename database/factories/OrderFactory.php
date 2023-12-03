<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $statuses = ['placed', 'paid', 'shipped', 'delivered', 'cancelled', 'returned'];
        return [
            'customer_id' => rand(1, 10),
            'subtotal' => 1000,
            'discount' => 0,
            'tax' => 0,
            'total' => 1000,
            'status' => $statuses[rand(0, 5)]
        ];
    }
}
