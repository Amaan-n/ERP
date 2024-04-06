<?php

namespace App\Repositories;

use App\Models\AssetCategory;

class CategoriesRepository
{
    protected $category;

    public function __construct()
    {
        $this->category = new AssetCategory();
    }

    public function getAssetCategories()
    {
        return $this->category->where('parent_id', 0)->get();
    }

    public function getAssetCategoryById($slug)
    {
        $category = $this->category->where('slug', $slug)->first();
        if (!isset($category)) {
            throw new \Exception('No query results for model [App\Models\Asset Category] ' . $slug, 201);
        }

        return $category;
    }

    public function store($data)
    {
        $data['slug'] = generate_slug('categories');
        return $this->category->create($data);
    }

    public function update($data, $id)
    {
        return $this->category->findOrFail($id)->update($data);
    }

    public function delete($slug)
    {
        return $this->category->where('slug', $slug)->firstOrFail()->delete();
    }
}
