<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function colorsSizes()
    {
        $sizes = Size::all();
        $colors = Color::all();

        return response()->json([
            'colors' => $colors,
            'sizes' => $sizes
        ]);
    }

    public function categories()
    {
        $categories = Category::query()
            ->with(['children'])
            ->parents()
            ->get();

        return response()->json($categories);
    }
}
