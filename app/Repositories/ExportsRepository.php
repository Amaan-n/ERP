<?php

namespace App\Repositories;

use App\Models\Product;

class ExportsRepository
{
    protected $product;

    public function __construct()
    {
        $this->product = new Product();
    }

    public function getDataCount($module_name)
    {
        $table = $this->product;
        switch ($module_name) {
            case 'products':
                $table = $this->product;
                break;
        }

        $records_count = $table->count();

        return $records_count ?? 0;
    }
}
