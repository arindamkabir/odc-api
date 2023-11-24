<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function store(array $attributes): Category
    {
        $category = new Category;
        $category->name = $attributes["name"];
        $category->parent_id = $attributes["parent_id"];
        $category->is_featured = $attributes["is_featured"];
        $category->is_hidden = $attributes["is_hidden"];
        $category->save();

        return $category;
    }

    public function update(string $id, array $attributes): Category
    {
        $category = Category::query()
            ->findOrFail($id);
        $category->name = $attributes["name"];
        $category->parent_id = $attributes["parent_id"];
        $category->is_featured = $attributes["is_featured"];
        $category->is_hidden = $attributes["is_hidden"];
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
