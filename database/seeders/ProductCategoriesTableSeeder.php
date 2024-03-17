<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product_category = new \App\Models\ProductCategory();
        $product_category->truncate();

        $product_category
            ->create([
                'slug'        => strtoupper(substr(md5(uniqid(rand(), true)), 0, 5)),
                'name'        => 'First Product Category',
                'description' => 'First Product Category... Description',
                'is_active'   => 1,
            ]);
    }
}
