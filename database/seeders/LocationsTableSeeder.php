<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $location = new \App\Models\Location();
        $location->truncate();

        $location
            ->create([
                'slug'        => strtoupper(substr(md5(uniqid(rand(), true)), 0, 5)),
                'name'        => 'First Location',
                'description' => 'First Location... Description',
                'location'    => '345 Water Street, Vancouver, BC, Canada',
                'latitude'    => '49.2846135',
                'longitude'   => '-123.1097971',
                'is_active'   => 1,
            ]);
    }
}
