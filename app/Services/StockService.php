<?php

namespace App\Services;

use App\Models\Stock;

class StockService
{
    public function store(array $attributes): Stock
    {
        $stock = new Stock;
        $stock->product_id = $attributes["product_id"];
        $stock->size_id = $attributes["size_id"] ? $attributes["size_id"] : null;
        $stock->color_id = $attributes["color_id"] ? $attributes["color_id"] : null;
        $stock->price = $attributes["price"];
        $stock->quantity = $attributes["quantity"];
        $stock->sales_price = $attributes["sales_price"];
        $stock->save();

        return $stock;
    }

    public function update(string $id, array $attributes): Stock
    {
        $stock = Stock::query()
            ->with(['product', 'product.stocks'])
            ->findOrFail($id);

        //! check if color and combo already exists
        $stock->size_id = $attributes["size_id"];
        $stock->color_id = $attributes["color_id"];
        $stock->price = $attributes["price"];
        $stock->quantity = $attributes["quantity"];
        $stock->sales_price = $attributes["sales_price"];
        $stock->save();

        return $stock;
    }

    public function delete(string $id): bool
    {
        $stock = Stock::query()
            ->findOrFail($id);

        return $stock->delete();
    }
}
