<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MeasuringUnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $measuring_unit = new \App\Models\MeasuringUnit();
        $measuring_unit->truncate();

        $data = [
            'BAG', 'BAL', 'BALE', 'BDL', 'BLISTER', 'BOX', 'CTN', 'DOZ', 'DRM', 'DRUM', 'FT', 'GAL', 'KG', 'KGS',
            'LTR', 'MTR', 'NO', 'PAIR', 'PAR', 'PC', 'PCS', 'PER', 'PKT', 'ROL', 'ROLL', 'SET', 'TRIP', 'YARD'];

        foreach ($data as $individual_data) {
            $measuring_unit
                ->create([
                    'slug'        => strtoupper(substr(md5(uniqid(rand(), true)), 0, 5)),
                    'name'        => $individual_data,
                    'description' => $individual_data . '... Description',
                    'is_active'   => 1,
                ]);
        }
    }
}
