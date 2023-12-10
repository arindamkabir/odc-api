<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\Services\ProductService;
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
            ->where('has_colors', true)
            ->where('has_sizes', true)
            ->paginate(10);

        return response()->json($products);
    }

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
            ->where('has_colors', true)
            ->where('has_sizes', true)
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
            ->with(['category', 'primaryImage', 'secondaryImage'])
            ->where('slug', $slug)
            ->firstOrFail();

        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        //
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
