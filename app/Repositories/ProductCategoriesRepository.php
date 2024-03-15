<?php

namespace App\Repositories;

use App\Models\ProductCategory;

class ProductCategoriesRepository
{
    protected $product_category;

    public function __construct()
    {
        $this->product_category = new ProductCategory();
    }

    public function getProductCategories()
    {
        return $this->product_category->get();
    }

    public function getProductCategoryById($slug)
    {
        $product_category = $this->product_category->where('slug', $slug)->first();
        if (!isset($product_category)) {
            throw new \Exception('No query results for model [App\Models\ProductCategory] ' . $slug, 201);
        }

        return $product_category;
    }

    public function store($data)
    {
        regenerate:
        $random_string = strtoupper(substr(md5(uniqid(rand(), true)), 0, 5));
        if ($this->product_category->where('slug', $random_string)->count()) {
            goto regenerate;
        }

        $data['slug'] = $random_string;
        return $this->product_category->create($data);
    }

    public function update($data, $id)
    {
        return $this->product_category->findOrFail($id)->update($data);
    }

    public function delete($slug)
    {
        $product_category = $this->product_category->where('slug', $slug)->first();
        if (!isset($product_category)) {
            throw new \Exception('No query results for model [App\Models\ProductCategory] ' . $slug, 201);
        }

        return $product_category->delete();
    }
}
