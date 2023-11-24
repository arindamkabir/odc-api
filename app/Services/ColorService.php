<?php

namespace App\Services;

use App\Models\Color;

class ColorService
{
    public function store(array $attributes): Color
    {
        $color = new Color;
        $color->name = $attributes["name"];
        $color->hex_code = $attributes["hex_code"];
        $color->save();

        return $color;
    }

    public function update(string $id, array $attributes): Color
    {
        $color = Color::query()->findOrFail($id);
        $color->name = $attributes['name'];
        $color->hex_code = $attributes['hex_code'];
        $color->save();

        return $color;
    }

    public function delete(string $id): bool
    {
        $color = Color::query()
            ->findOrFail($id);

        return $color->delete();
    }
}
