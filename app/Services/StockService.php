<?php

namespace App\Services;

use App\Models\Stock;

class StockService
{
    public function store(array $attributes): Stock
    {
        $stock = new Stock;
        $stock->product_id = $attributes["product_id"];
        $stock->size_id = $attributes["size_id"];
        $stock->color_id = $attributes["color_id"];
        $stock->quantity = $attributes["quantity"];
        $stock->save();

        return $stock;
    }

    public function update(string $id, array $attributes): Stock
    {
        $stock = Stock::query()
            ->findOrFail($id);
        $stock->size_id = $attributes["size_id"];
        $stock->color_id = $attributes["color_id"];
        $stock->quantity = $attributes["quantity"];
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
