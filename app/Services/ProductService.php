<?php

namespace App\Services;

use App\Models\Image as ModelsImage;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;

class ProductService
{
    public function store(array $attributes): Product
    {
        return DB::transaction(function () use ($attributes) {
            $product = new Product;
            $product->name = $attributes['name'];
            $product->description = $attributes['description'];
            $product->price = $attributes['price'];
            $product->category_id = $attributes['category_id'];
            $product->SKU = $attributes['SKU'];
            $product->is_featured = $attributes['is_featured'] === "true" ? true : false;
            $product->is_hidden = $attributes['is_hidden'] === "true" ? true : false;
            $product->save();

            $this->storeImage($product, $attributes['primary_img'], null, 'primary');
            if (isset($attributes['secondary_img'])) $this->storeImage($product, $attributes['secondary_img'], null, 'secondary');

            if (count($attributes['stocks']) > 0)
                foreach ($attributes['stocks'] as $stock) {
                    $product->stocks()->create([
                        'size_id' => $stock['size_id'],
                        'color_id' => $stock['color_id'],
                        'quantity' => $stock['quantity'],
                        'price' => $stock['price']
                    ]);
                }


            // if (count($attributes['images']) > 0)
            //     foreach ($attributes['images'] as $image) {
            //         $this->storeImage($product, $image);
            //     }

            return $product;
        });
    }

    public function update(Product $product, array $attributes)
    {
        $product->name = $attributes['name'];
        $product->description = $attributes['description'];
        $product->price = $attributes['price'];
        $product->category_id = $attributes['categoryId'];
        $product->SKU = $attributes['SKU'];
        $product->is_featured = $attributes['isFeatured'];
        $product->is_hidden = $attributes['isHidden'];
        $product->save();
    }


    /**
     *
     * Helper function to process images using Spatie Image
     */
    protected function processImage($path, $cropDetails = null, $optimize = false)
    {
        $image = Image::load($path);

        if ($cropDetails !== null)
            $image->manualCrop(
                $cropDetails['width'],
                $cropDetails['height'],
                $cropDetails['x'],
                $cropDetails['y']
            );

        $image->fit(Manipulations::FIT_CONTAIN, 1000, 1000);

        if ($optimize) $image->optimize();

        $image->save();
    }

    /**
     *
     * Helper function to store new images for product
     */
    protected function storeImage(Product $product, $image, $cropDetails = null, $type = null): ModelsImage
    {
        $path = $image->store('images/products/' . $product->slug, 'public');

        $this->processImage(
            Storage::disk('public')->path($path),
            $cropDetails,
            true
        );

        $imageModel = new ModelsImage([
            'url' => $path,
            'type' => $type
        ]);

        $product->images()->save($imageModel);

        return $imageModel;
    }

    public function delete($id)
    {
        $product = Product::query()->findOrFail($id);
        return $product->delete();
    }
}
