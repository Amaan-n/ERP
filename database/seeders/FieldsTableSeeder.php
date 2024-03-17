<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FieldsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $field = new \App\Models\Field();
        $field->truncate();

        $field
            ->create([
                'slug'        => strtoupper(substr(md5(uniqid(rand(), true)), 0, 5)),
                'name'        => 'Manufacturing Date',
                'description' => 'Manufacturing Date',
                'element'     => 'text',
                'is_active'   => 1,
            ]);
    }
}
