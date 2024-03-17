<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\Models\User();
        $user->truncate();

        $user
            ->create([
                'group_id'          => 2,
                'slug'              => strtoupper(substr(md5(uniqid(rand(), true)), 0, 5)),
                'name'              => 'Juzar Shabbir',
                'email'             => 'juzar@almerak.com',
                'phone'             => '66327768',
                'password'          => bcrypt(123456),
                'is_active'         => 1,
                'is_root_user'      => 1,
                'email_verified_at' => \Carbon\Carbon::now()
            ]);

        $user
            ->create([
                'group_id'          => 2,
                'slug'              => strtoupper(substr(md5(uniqid(rand(), true)), 0, 5)),
                'name'              => 'Shakir Ali',
                'email'             => 'ali@almerak.com',
                'phone'             => '60637521',
                'password'          => bcrypt(123456),
                'is_active'         => 1,
                'is_root_user'      => 1,
                'email_verified_at' => \Carbon\Carbon::now()
            ]);
    }
}
