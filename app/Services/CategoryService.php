<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function store(array $attributes): Category
    {
        $category = new Category;
        $category->name = $attributes["name"];
        $category->parent_id = $attributes["parent_id"] ?? null;
        $category->is_featured = $attributes["is_featured"] === "true" ? true : false;
        $category->is_hidden = $attributes["is_hidden"] === "true" ? true : false;
        $category->save();

        return $category;
    }

    public function update(string $id, array $attributes): Category
    {
        $category = Category::query()
            ->findOrFail($id);
        $category->name = $attributes["name"];
        $category->parent_id = $attributes["parent_id"] ?? null;
        $category->is_featured = $attributes["is_featured"] === "true" ? true : false;
        $category->is_hidden = $attributes["is_hidden"] === "true" ? true : false;
        $category->save();

        return $category;
    }

    public function delete($id): bool
    {
        $category = Category::query()
            ->findOrFail($id);

        return $category->delete();
    }
}
