<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SuppliersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $supplier = new \App\Models\Supplier();
        $supplier->truncate();

        $supplier
            ->create([
                'slug'           => strtoupper(substr(md5(uniqid(rand(), true)), 0, 5)),
                'name'           => 'Earth Solutions Pvt. Ltd.',
                'contact_person' => 'Murtaza Vohra',
                'phone'          => '65643177',
                'email'          => 'murtaza@almerak.com',
                'description'    => 'Earth Solutions Pvt. Ltd.',
                'is_active'      => 1,
            ]);
    }
}
