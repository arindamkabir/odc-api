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
        $product_id = rand(1, 50);

        return [
            // 'order_id' => rand(1, 100),
            'quantity' => function (array $attributes) use ($product_id) {
                $quantity = rand(1, 15);
                $order = Order::find($attributes['order_id']);
                $price = Product::find($product_id)->stocks()->first()->price;
                // Add order items total to orders total and subtotal
                $order->subtotal = $order->subtotal + ($quantity * $price);
                $order->total = $order->total + ($quantity * $price);
                $order->save();
                return $quantity;
            },
            'price' => function (array $attributes) use ($product_id) {
                $price = Product::find($product_id)->stocks()->first()->price;
                return $price;
            },
            'stock_id' => function (array $attributes) use ($product_id) {
                $stock = Product::find($product_id)->stocks()->first();
                return $stock->id;
            },
            'product_id' => $product_id
        ];
    }
}
