<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderItem;
use App\Models\StripeCharge;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::factory(100)
            ->has(OrderAddress::factory()->state(function (array $attributes, Order $order) {
                return ['type' => 'shipping'];
            }), 'shipping')
            ->has(OrderItem::factory()->count(rand(2, 10)), 'order_items')
            ->has(Transaction::factory()->has(StripeCharge::factory(), 'stripeCharge'), 'transaction')
            ->create();
    }
}
