<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Size\StoreSizeRequest;
use App\Http\Requests\Size\UpdateSizeRequest;
use App\Models\Size;
use App\Services\SizeService;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    private SizeService $sizeService;

    public function __construct(SizeService $sizeService)
    {
        $this->sizeService = $sizeService;
    }

    public function index()
    {
        $sizes = Size::query()
            ->paginate(10);

        return response()->json($sizes);
    }

    public function store(StoreSizeRequest $request)
    {
        $validated = $request->validated();

        $size = $this->sizeService->store($validated);

        return response()->json($size);
    }

    public function update(UpdateSizeRequest $request, string $id)
    {
        $validated = $request->validated();

        $size = $this->sizeService->update($id, $validated);

        return response()->json('Size updated successfully.');
    }

    public function destroy(string $id)
    {
        $deleted = $this->sizeService->delete($id);

        return response()->json($deleted);
    }
}
