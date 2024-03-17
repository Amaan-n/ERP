<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ManufacturersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manufacturer = new \App\Models\Manufacturer();
        $manufacturer->truncate();

        $manufacturer
            ->create([
                'slug'           => strtoupper(substr(md5(uniqid(rand(), true)), 0, 5)),
                'name'           => 'Apple',
                'contact_person' => 'Murtaza Vohra',
                'phone'          => '65643177',
                'email'          => 'murtaza@almerak.com',
                'description'    => 'Apple',
                'is_active'      => 1,
            ]);
    }
}
