<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomersRepository
{
    protected $customer;

    public function __construct()
    {
        $this->customer = new Customer();
    }

    public function getCustomers()
    {
        return $this->customer->get();
    }

    public function getCustomerById($slug)
    {
        $customer = $this->customer->where('slug', $slug)->first();
        if (!isset($customer)) {
            throw new \Exception('No query results for model [App\Models\Customer] ' . $slug, 201);
        }

        return $customer;
    }

    public function store($data)
    {
        regenerate:
        $random_string = strtoupper(substr(md5(uniqid(rand(), true)), 0, 5));
        if ($this->customer->where('slug', $random_string)->count()) {
            goto regenerate;
        }

        $data['slug'] = $random_string;
        return $this->customer->create($data);
    }

    public function update($data, $id)
    {
        return $this->customer->findOrFail($id)->update($data);
    }

    public function delete($slug)
    {
        $customer = $this->customer->where('slug', $slug)->first();
        if (!isset($customer)) {
            throw new \Exception('No query results for model [App\Models\Customer] ' . $slug, 201);
        }

        return $customer->delete();
    }
}
