<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $department = new \App\Models\Department();
        $department->truncate();

        $department
            ->create([
                'slug'           => strtoupper(substr(md5(uniqid(rand(), true)), 0, 5)),
                'name'           => 'Security',
                'description'    => 'Security.',
                'is_active'      => 1,
            ]);
    }
}
