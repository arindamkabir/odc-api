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
            $product->has_colors = $attributes['has_colors'] === "true" ? true : false;
            $product->has_sizes = $attributes['has_sizes'] === "true" ? true : false;
            $product->is_featured = $attributes['is_featured'] === "true" ? true : false;
            $product->is_hidden = $attributes['is_hidden'] === "true" ? true : false;
            $product->save();

            $this->storeImage($product, $attributes['primary_img'], null, 'primary');
            if (isset($attributes['secondary_img'])) $this->storeImage($product, $attributes['secondary_img'], null, 'secondary');

            if (isset($attributes['stocks']))
                if (count($attributes['stocks']) > 0)
                    foreach ($attributes['stocks'] as $stock) {
                        $product->stocks()->create([
                            'size_id' => $attributes['has_sizes'] === "true" ? $stock['size_id'] : null,
                            'color_id' => $attributes['has_colors'] === "true" ? $stock['color_id'] : null,
                            'quantity' => $stock['quantity'],
                            'price' => $stock['price']
                        ]);
                    }
            return $product;
        });
    }

    public function addImages(string $product_id, array $attributes)
    {
        return DB::transaction(function () use ($product_id, $attributes) {
            if (count($attributes['images']) > 0) {

                $product = Product::query()->with(["primaryImage"])->findOrFail($product_id);
                foreach ($attributes['images'] as $image) {
                    $this->storeImage($product, $image);
                }
            }
        });
    }

    public function deleteImage(string $id)
    {
        $image = ModelsImage::query()->findOrFail($id);
        $deleted = $image->delete();

        return $deleted;
    }

    public function update(string $id, array $attributes)
    {
        $product = Product::query()->findOrFail($id);
        $product->name = $attributes['name'];
        $product->description = $attributes['description'];
        $product->price = $attributes['price'];
        $product->sales_price = $attributes['sales_price'];
        $product->category_id = $attributes['category_id'];
        $product->SKU = $attributes['SKU'];
        $product->has_colors = $attributes['has_colors'] === "true" ? true : false;
        $product->has_sizes = $attributes['has_sizes'] === "true" ? true : false;
        $product->is_featured = $attributes['is_featured'] === "true" ? true : false;
        $product->is_hidden = $attributes['is_hidden'] === "true" ? true : false;
        $product->save();
    }

    public function updatePrimaryImage(string $product_id, $attributes)
    {
        return DB::transaction(function () use ($product_id, $attributes) {
            $product = Product::query()->with(["primaryImage"])->findOrFail($product_id);
            $oldPrimaryImage = $product->primaryImage;

            $this->storeImage($product, $attributes['primary_img'], null, 'primary');

            Storage::disk('public')->delete($oldPrimaryImage->url);
            $oldPrimaryImage->delete();

            return $product->fresh(["primaryImage"]);
        });
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
