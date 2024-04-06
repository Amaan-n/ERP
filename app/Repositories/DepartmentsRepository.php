<?php

namespace App\Repositories;

use App\Models\Department;

class DepartmentsRepository
{
    protected $department;

    public function __construct()
    {
        $this->department = new Department();
    }

    public function getDepartments()
    {
        return $this->department->get();
    }

    public function getDepartmentById($slug)
    {
        $department = $this->department->where('slug', $slug)->first();
        if (!isset($department)) {
            throw new \Exception('No query results for model [App\Models\Department] ' . $slug, 201);
        }

        return $department;
    }

    public function store($data)
    {
        $data['slug'] = generate_slug('departments');
        return $this->department->create($data);
    }

    public function update($data, $id)
    {
        return $this->department->findOrFail($id)->update($data);
    }

    public function delete($slug)
    {
        return $this->department->where('slug', $slug)->firstOrFail()->delete();
    }
}
