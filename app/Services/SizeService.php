<?php

namespace App\Services;

use App\Models\Size;

class SizeService
{
    public function store(array $attributes): Size
    {
        $size = new Size;
        $size->name = $attributes["name"];
        $size->save();

        return $size;
    }

    public function update(string $id, array $attributes): Size
    {
        $size = Size::query()->findOrFail($id);
        $size->name = $attributes['name'];
        $size->save();

        return $size;
    }

    public function delete(string $id): bool
    {
        $size = Size::query()
            ->findOrFail($id);

        return $size->delete();
    }
}
