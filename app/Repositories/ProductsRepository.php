<?php

namespace App\Repositories;

use App\Models\Product;

class ProductsRepository
{
    protected $product;

    public function __construct()
    {
        $this->product = new Product();
    }

    public function getProducts()
    {
        return $this->product->with('product_category')->get();
    }

    public function getProductById($slug)
    {
        $product = $this->product->with('product_category')->where('slug', $slug)->first();
        if (!isset($product)) {
            throw new \Exception('No query results for model [App\Models\Product] ' . $slug, 201);
        }

        return $product;
    }

    public function store($data)
    {
        $data['slug'] = generate_slug('products');
        return $this->product->create($data);
    }

    public function update($data, $id)
    {
        return $this->product->findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return $this->product->findOrFail($id)->delete();
    }
}
