<?php

namespace App\Repositories;

use App\Models\Manufacturer;

class ManufacturersRepository
{
    protected $manufacturer;

    public function __construct()
    {
        $this->manufacturer = new Manufacturer();
    }

    public function getManufacturers()
    {
        return $this->manufacturer->get();
    }

    public function getManufacturerById($slug)
    {
        $manufacturer = $this->manufacturer->where('slug', $slug)->first();
        if (!isset($manufacturer)) {
            throw new \Exception('No query results for model [App\Models\Manufacturer] ' . $slug, 201);
        }

        return $manufacturer;
    }

    public function store($data)
    {
        $data['slug'] = generate_slug('manufacturers');
        return $this->manufacturer->create($data);
    }

    public function update($data, $id)
    {
        return $this->manufacturer->findOrFail($id)->update($data);
    }

    public function delete($slug)
    {
        return $this->manufacturer->where('slug', $slug)->firstOrFail()->delete();
    }
}
