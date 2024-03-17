<?php

namespace App\Repositories;

use App\Models\User;

class EmployeesRepository
{
    protected $employee;

    public function __construct()
    {
        $this->employee = new User();
    }

    public function getEmployees()
    {
        return $this->employee
            ->with('group')
            ->where('group_id', 2)
            ->get();
    }

    public function getEmployeeById($slug)
    {
        $employee = $this->employee->with('group')->where('slug', $slug)->first();
        if (!isset($employee)) {
            throw new \Exception('No query results for model [App\Models\Employee] ' . $slug, 201);
        }

        return $employee;
    }

    public function store($data)
    {
        regenerate:
        $random_string = strtoupper(substr(md5(uniqid(rand(), true)), 0, 5));
        if ($this->employee->where('slug', $random_string)->count()) {
            goto regenerate;
        }

        $data['slug'] = $random_string;
        return $this->employee->create($data);
    }

    public function update($data, $id)
    {
        $employee = $this->employee->findOrFail($id);
        $employee->update($data);
        return $employee;
    }

    public function delete($slug)
    {
        $employee = $this->employee->where('slug', $slug)->first();
        if (!isset($employee)) {
            throw new \Exception('No query results for model [App\Models\Employee] ' . $slug, 201);
        }

        return $employee->delete();
    }

    public function updatePassword($data)
    {
        return $this->employee
            ->where('id', $data['id'])
            ->update([
                'password' => $data['password']
            ]);
    }
}
