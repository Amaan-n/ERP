<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = new \App\Models\Product();
        $product->truncate();

        for ($i = 1; $i <= 9; $i++) {
            $product
                ->create([
                    'slug'                => strtoupper(substr(md5(uniqid(rand(), true)), 0, 5)),
                    'product_category_id' => 1,
                    'name'                => 'Product ' . $i,
                    'price'               => 100,
                    'barcode'             => 123456789 . $i,
                    'description'         => 'Product ' . $i . '... Description',
                    'is_active'           => 1,
                ]);
        }
    }
}
