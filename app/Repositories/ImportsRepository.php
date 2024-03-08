<?php

namespace App\Repositories;

use App\Models\Product;

class ImportsRepository
{
    protected $product;

    public function __construct()
    {
        $this->product = new Product();
    }
}
