<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer = new \App\Models\Customer();
        $customer->truncate();

        $customer
            ->create([
                'slug'      => strtoupper(substr(md5(uniqid(rand(), true)), 0, 5)),
                'name'      => 'Murtaza Vohra',
                'email'     => 'murtaza@almerak.com',
                'phone'     => '65643177',
                'is_active' => 1,
                'about'     => 'Default Customer',
            ]);
    }
}
