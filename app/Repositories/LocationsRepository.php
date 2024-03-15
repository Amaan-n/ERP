<?php

namespace App\Repositories;

use App\Models\Location;

class LocationsRepository
{
    protected $location;

    public function __construct()
    {
        $this->location = new Location();
    }

    public function getLocations()
    {
        return $this->location->get();
    }

    public function getLocationById($slug)
    {
        $location = $this->location->where('slug', $slug)->first();
        if (!isset($location)) {
            throw new \Exception('No query results for model [App\Models\Location] ' . $slug, 201);
        }

        return $location;
    }

    public function store($data)
    {
        regenerate:
        $random_string = strtoupper(substr(md5(uniqid(rand(), true)), 0, 5));
        if ($this->location->where('slug', $random_string)->count()) {
            goto regenerate;
        }

        $data['slug'] = $random_string;
        return $this->location->create($data);
    }

    public function update($data, $id)
    {
        return $this->location->findOrFail($id)->update($data);
    }

    public function delete($slug)
    {
        $location = $this->location->where('slug', $slug)->first();
        if (!isset($location)) {
            throw new \Exception('No query results for model [App\Models\Location] ' . $slug, 201);
        }

        return $location->delete();
    }
}
