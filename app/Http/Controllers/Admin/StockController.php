<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Stock\StoreStockRequest;
use App\Http\Requests\Stock\UpdateStockRequest;
use App\Models\Stock;
use App\Services\StockService;
use Illuminate\Http\Request;

class StockController extends Controller
{
    private StockService $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    public function index(string $id)
    {
        $stocks = Stock::query()
            ->with(['color', 'size'])
            ->where('product_id', $id)
            ->get();

        return response()->json($stocks);
    }

    public function store(StoreStockRequest $request)
    {
        $validated = $request->validated();

        $stock = $this->stockService->store($validated);

        return response()->json($stock);
    }

    public function update(UpdateStockRequest $request, string $id)
    {
        $validated = $request->validated();

        $stock = $this->stockService->update($id, $validated);

        return response()->json($stock);
    }
}
