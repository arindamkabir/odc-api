<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Color\StoreColorRequest;
use App\Http\Requests\Color\UpdateColorRequest;
use App\Models\Color;
use App\Services\ColorService;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    private ColorService $colorService;

    public function __construct(ColorService $colorService)
    {
        $this->colorService = $colorService;
    }

    public function index()
    {
        $colors = Color::query()
            ->paginate(10);

        return response()->json($colors);
    }

    public function store(StoreColorRequest $request)
    {
        $validated = $request->validated();

        $color = $this->colorService->store($validated);

        return response()->json($color);
    }

    public function update(UpdateColorRequest $request, string $id)
    {
        $validated = $request->validated();

        $color = $this->colorService->update($id, $validated);

        return response()->json('Color updated successfully.');
    }

    public function destroy(string $id)
    {
        $deleted = $this->colorService->delete($id);

        return response()->json($deleted);
    }
}
