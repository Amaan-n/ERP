<?php

namespace App\Repositories;

use App\Models\Supplier;

class SuppliersRepository
{
    protected $supplier;

    public function __construct()
    {
        $this->supplier = new Supplier();
    }

    public function getSuppliers()
    {
        return $this->supplier->get();
    }

    public function getSupplierById($slug)
    {
        $supplier = $this->supplier->where('slug', $slug)->first();
        if (!isset($supplier)) {
            throw new \Exception('No query results for model [App\Models\Supplier] ' . $slug, 201);
        }

        return $supplier;
    }

    public function store($data)
    {
        $data['slug'] = generate_slug('suppliers');
        return $this->supplier->create($data);
    }

    public function update($data, $id)
    {
        return $this->supplier->findOrFail($id)->update($data);
    }
    public function delete($slug)
    {
        return $this->supplier->where('slug', $slug)->firstOrFail()->delete();
    }
}
