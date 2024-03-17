<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AssetModelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $asset_model = new \App\Models\AssetModel();
        $asset_model->truncate();

        $asset_model
            ->create([
                'slug'              => strtoupper(substr(md5(uniqid(rand(), true)), 0, 5)),
                'manufacturer_id'   => 1,
                'asset_category_id' => 1,
                'field_group_id'    => 1,
                'name'              => 'Macbook M1 - 256GB',
                'model_number'      => 'M1-123456',
                'notes'             => 'Macbook M1 - 256GB',
                'is_active'         => 1,
            ]);
    }
}
