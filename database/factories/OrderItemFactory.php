<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => rand(1, 50),
            // 'order_id' => rand(1, 100),
            'quantity' => function (array $attributes) {
                $quantity = rand(1, 15);
                $order = Order::find($attributes['order_id']);
                $price = Product::find($attributes['product_id'])->price;
                // Add order items total to orders total and subtotal
                $order->subtotal = $order->subtotal + ($quantity * $price);
                $order->total = $order->total + ($quantity * $price);
                $order->save();
                return $price;
            },
            'size_id' => function (array $attributes) {
                $stock = Product::find($attributes['product_id'])->stocks()->first();
                return $stock->size_id;
            },
            'color_id' => function (array $attributes) {
                $stock = Product::find($attributes['product_id'])->stocks()->first();
                return $stock->color_id;
            },
        ];
    }
}
