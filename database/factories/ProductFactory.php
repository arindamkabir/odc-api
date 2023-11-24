<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->unique()->words($nb = 4, $asText = true);
        $slug = Str::slug($name);
        $pImgName = uniqid() . '.jpg';
        $sImgName = uniqid() . '.jpg';
        $path = 'images/products/' . $slug;
        Storage::disk('public')->putFileAs($path, new File(storage_path('test_images/' . rand(1, 26) . '.jpg')), $pImgName);
        Storage::disk('public')->putFileAs($path, new File(storage_path('test_images/' . rand(1, 26) . '.jpg')), $sImgName);

        return [
            'name' => $name,
            'slug' => $slug,
            'description' => $this->faker->text(40),
            'price' => $this->faker->numberBetween(30, 60),
            'SKU' => $this->faker->unique()->numberBetween(1000000, 9999999),
            'category_id' => rand(3, 8),
            'on_sale' => false,
            'is_hidden' => false,
            'has_colors' => true,
            'has_sizes' => true
        ];
    }
}
