<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query("per_page", 10);
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
            ->orderBy('created_at', 'desc')
            ->cursorPaginate(12);

        return response()->json($products);
    }

    public function show(string $slug)
    {
        $product = Product::query()
            ->with(['category', 'primaryImage', 'stocks', 'stocks.color', 'stocks.size'])
            ->withCount(['sizes', 'colors'])
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedProducts = Product::query()
            ->with(['category', 'primaryImage', 'stocks', 'stocks.color', 'stocks.size'])
            ->latest()
            ->limit(4)
            ->get();

        $sizes = Size::all();

        return response()->json([
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'sizes' => $sizes
        ]);
    }

    public function category(Request $request, string $slug)
    {
        $sizes = count($request->query("sizes", [])) > 0 ? $request->query("sizes") : null;
        $colors = count($request->query("colors", [])) > 0 ? $request->query("colors") : null;

        $products = Product::query()
            ->with(['category', 'primaryImage', 'stocks', 'stocks.color', 'stocks.size'])
            ->withCount(['sizes', 'colors'])
            ->when(
                $sizes,
                fn ($query, $arr) => $query->ofSizes($arr)
            )
            ->when(
                $colors,
                fn ($query, $arr) => $query->ofColors($arr)
            )
            ->whereHas('category', function (Builder $query) use ($slug) {
                $query->where('slug', $slug);
            })
            ->orderBy('created_at', 'desc')
            ->cursorPaginate(12);

        return response()->json($products);
    }
}
