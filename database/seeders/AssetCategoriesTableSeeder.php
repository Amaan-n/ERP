<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AssetCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $asset_category = new \App\Models\AssetCategory();
        $asset_category->truncate();

        $asset_category
            ->create([
                'slug'        => strtoupper(substr(md5(uniqid(rand(), true)), 0, 5)),
                'name'        => 'Laptop',
                'description' => 'Laptop',
                'is_active'   => 1,
            ]);
    }
}
