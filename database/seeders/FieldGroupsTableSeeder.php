<?php

namespace Database\Seeders;

use App\Models\FieldGroupHasField;
use Illuminate\Database\Seeder;

class FieldGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $field_group = new \App\Models\FieldGroup();
        $field_group->truncate();

        $field_group
            ->create([
                'slug'        => strtoupper(substr(md5(uniqid(rand(), true)), 0, 5)),
                'name'        => 'Basic Information',
                'description' => 'Basic Information',
                'is_active'   => 1,
            ]);

        FieldGroupHasField::create([
            'field_group_id' => 1,
            'field_id'       => 1
        ]);
    }
}
