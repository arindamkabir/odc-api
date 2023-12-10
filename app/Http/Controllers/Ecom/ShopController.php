<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function getFilters()
    {
        $sizes = Size::all();
        $colors = Color::all();
        $categories = Category::query()
            ->with(['children'])
            ->parents()
            ->get();

        return response()->json([
            'categories' => $categories,
            'colors' => $colors,
            'sizes' => $sizes
        ]);
    }
}
