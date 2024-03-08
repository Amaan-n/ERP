<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ConfigurationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $configurations = config('configurations');

        $configuration = new \App\Models\Configuration();
        $configuration->truncate();

        // configurations
        foreach ($configurations as $parent_value) {
            $parent_configuration = $configuration
                ->create([
                    'parent_id'    => 0,
                    'grid'         => $parent_value['grid'],
                    'key'          => $parent_value['key'],
                    'display_text' => $parent_value['display_text'],
                    'is_visible'   => $parent_value['is_visible'],
                    'value'        => $parent_value['value'],
                    'input_type'   => $parent_value['input_type'],
                ]);


            if (!empty($parent_value['children'])) {
                foreach ($parent_value['children'] as $child_value) {
                    $configuration
                        ->create([
                            'parent_id'    => $parent_configuration->id,
                            'grid'         => $child_value['grid'],
                            'key'          => $child_value['key'],
                            'display_text' => $child_value['display_text'],
                            'is_visible'   => $child_value['is_visible'],
                            'value'        => $child_value['value'],
                            'input_type'   => $child_value['input_type'],
                            'options'      => isset($child_value['options']) ? json_encode($child_value['options']) : null
                        ]);
                }
            }
        }
    }
}
