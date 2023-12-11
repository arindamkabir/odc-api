<?php

namespace App\Services;

use App\Models\CashTransaction;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Transaction;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function store(array $attributes)
    {
        return DB::transaction(function () use ($attributes) {
            $productIds = [];
            $orderItems = [];

            $subtotal = 0;
            $salesPriceDiscount = 0;


            foreach ($attributes["products"] as $key => $value) {
                $productIds[] = $value['id'];
            }

            $products = Product::query()
                ->with(['stocks'])
                ->whereIn('id', $productIds)
                ->get();

            foreach ($attributes["products"] as $key => $value) {
                $product = $products->find($value['id']);
                $stock = $product->stocks->find($value['stock_id']);

                if (!$product || !$stock) throw new Exception('Product not found.');
                if ($stock->quantity < $value["quantity"]) throw new Exception('Product out of stock.');

                $orderItems[] = new OrderItem([
                    'price' => $stock->price,
                    'sales_price' => $stock->sales_price,
                    'quantity' => $value["quantity"],
                    'stock_id' => $value['stock_id']
                ]);

                $subtotal += (floatval($stock->price) * floatval($value["quantity"]));
                $salesPriceDiscount += $stock->sales_price ? ((floatval($stock->price) - floatval($stock->sales_price)) * floatval($value["quantity"])) : 0;

                $stock->quantity = $stock->quantity - $value["quantity"];
                $stock->save();
            }

            $shippingCost = $attributes["delivery_location"] === "dhaka" ? 70 : 200;

            //! need to add coupon logic

            $discount = $salesPriceDiscount;

            $total = $subtotal + $shippingCost - $discount;

            $order = new Order;
            $order->customer_id = null;
            $order->coupon_id = null;
            $order->subtotal = $subtotal;
            $order->discount = $discount;
            $order->shipping_cost  = $shippingCost;
            $order->total = $total;
            $order->is_billing_different = false;
            $order->delivery_location = $attributes["delivery_location"];

            //! add bkash personal logic
            $order->status = 'placed';
            $order->save();

            $order->order_items()->saveMany($orderItems);

            $cashTxn = new CashTransaction;
            $cashTxn->save();

            $transaction = new Transaction;
            $transaction->order_id = $order->id;
            $transaction->transactable_id = $cashTxn->id;
            $transaction->transactable_type = 'App\Models\CashTransaction';
            $transaction->save();

            $shipping = new OrderAddress;
            $shipping->order_id = $order->id;
            $shipping->f_name = $attributes['f_name'];
            $shipping->l_name = $attributes['l_name'];
            $shipping->phone = $attributes['phone'];
            $shipping->email = $attributes['email'];
            $shipping->line1 = $attributes['address'];
            $shipping->line2 = $attributes['address_2'];
            $shipping->city = $attributes['city'];
            $shipping->state = $attributes['state'];
            $shipping->country = "Bangladesh";
            $shipping->zip_code = $attributes['zip_code'];
            $shipping->type = "shipping";
            $shipping->save();

            return $order->load(['shipping', 'transaction', 'order_items']);
        });
    }
}
