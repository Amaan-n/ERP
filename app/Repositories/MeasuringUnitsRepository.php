<?php

namespace App\Repositories;

use App\Models\MeasuringUnit;

class MeasuringUnitsRepository
{
    protected $measuring_unit;

    public function __construct()
    {
        $this->measuring_unit = new MeasuringUnit();
    }

    public function getMeasuringUnits()
    {
        return $this->measuring_unit->get();
    }

    public function getMeasuringUnitById($slug)
    {
        $measuring_unit = $this->measuring_unit->where('slug', $slug)->first();
        if (!isset($measuring_unit)) {
            throw new \Exception('No query results for model [App\Models\MeasuringUnit] ' . $slug, 201);
        }

        return $measuring_unit;
    }

    public function store($data)
    {
        regenerate:
        $random_string = strtoupper(substr(md5(uniqid(rand(), true)), 0, 5));
        if ($this->measuring_unit->where('slug', $random_string)->count()) {
            goto regenerate;
        }

        $data['slug'] = $random_string;
        return $this->measuring_unit->create($data);
    }

    public function update($data, $id)
    {
        return $this->measuring_unit->findOrFail($id)->update($data);
    }

    public function delete($slug)
    {
        $measuring_unit = $this->measuring_unit->where('slug', $slug)->first();
        if (!isset($measuring_unit)) {
            throw new \Exception('No query results for model [App\Models\MeasuringUnit] ' . $slug, 201);
        }

        return $measuring_unit->delete();
    }
}
