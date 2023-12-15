<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Requests\Product\StoreProductImageRequest;
use App\Http\Requests\Product\UpdateProductPrimaryImageRequest;
use App\Models\Order;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = count($request->query("categories", [])) > 0 ? $request->query("categories") : null;
        $sizes = count($request->query("sizes", [])) > 0 ? $request->query("sizes") : null;
        $colors = count($request->query("colors", [])) > 0 ? $request->query("colors") : null;

        $products = Product::query()
            ->with(['category', 'primaryImage', 'stocks', 'stocks.color', 'stocks.size'])
            ->withCount(['sizes', 'colors'])
            ->when(
                $request->query("search"),
                fn ($query, $term) => $query->search($term)
            )
            ->when(
                $categories,
                fn ($query, $arr) => $query->OfParentCategories($arr)
            )
            ->when(
                $sizes,
                fn ($query, $arr) => $query->ofSizes($arr)
            )
            ->when(
                $colors,
                fn ($query, $arr) => $query->ofColors($arr)
            )
            ->paginate(10);

        return response()->json($products);
    }

    // public function getRelationCount(Request $request)
    // {
    // }

    public function cursorPaginate(Request $request)
    {
        $categories = count($request->query("categories", [])) > 0 ? $request->query("categories") : null;
        $sizes = count($request->query("sizes", [])) > 0 ? $request->query("sizes") : null;
        $colors = count($request->query("colors", [])) > 0 ? $request->query("colors") : null;

        $products = Product::query()
            ->with(['category', 'primaryImage', 'stocks', 'stocks.color', 'stocks.size'])
            ->withCount(['sizes', 'colors'])
            ->when(
                $request->query("search"),
                fn ($query, $term) => $query->search($term)
            )
            ->when(
                $categories,
                fn ($query, $arr) => $query->OfParentCategories($arr)
            )
            ->when(
                $sizes,
                fn ($query, $arr) => $query->ofSizes($arr)
            )
            ->when(
                $colors,
                fn ($query, $arr) => $query->ofColors($arr)
            )
            ->orderBy('id', 'desc')
            ->cursorPaginate(10);

        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        $product = $this->productService->store($validated);

        return response()->json($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $product = Product::query()
            ->with(['category', 'primaryImage', 'stocks', 'stocks.color', 'stocks.size', 'extraImages'])
            ->where('slug', $slug)
            ->firstOrFail();

        // $orders = Order::query()
        //     ->whereHas('order_items', function (Builder $query) use ($product) {
        //         $query->whereIn('stock_id', $product->stocks->pluck('id'));
        //     })
        //     ->paginate(10, ['*'], 'order-page');

        return response()->json(['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        $product = $this->productService->update($product, $validated);

        return response()->json($product);
    }

    public function updatePrimaryImage(UpdateProductPrimaryImageRequest $request, string $id)
    {
        $validated = $request->validated();

        $product = $this->productService->updatePrimaryImage($id, $validated);

        return response()->json($product);
    }

    public function addImages(StoreProductImageRequest $request, string $id)
    {
        $validated = $request->validated();

        $product = $this->productService->addImages($id, $validated);

        return response()->json($product);
    }

    public function deleteImage(string $id)
    {
        $deleted = $this->productService->deleteImage($id);

        return response()->json($deleted);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleted = $this->productService->delete($id);

        return response()->json("Product deleted successfully");
    }
}
