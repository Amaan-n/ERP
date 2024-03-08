<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
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
                'group_id'          => 1,
                'slug'              => strtoupper(substr(md5(uniqid(rand(), true)), 0, 5)),
                'name'              => 'Murtaza Vohra',
                'email'             => 'murtaza@almerak.com',
                'phone'             => '65643177',
                'password'          => bcrypt(123456),
                'is_active'         => 1,
                'is_root_user'      => 1,
                'email_verified_at' => \Carbon\Carbon::now()
            ]);

        $user
            ->create([
                'group_id'          => 1,
                'slug'              => strtoupper(substr(md5(uniqid(rand(), true)), 0, 5)),
                'name'              => 'Hakim Maudi',
                'email'             => 'hakim@almerak.com',
                'phone'             => '67685242',
                'password'          => bcrypt(123456),
                'is_active'         => 1,
                'is_root_user'      => 1,
                'email_verified_at' => \Carbon\Carbon::now()
            ]);
    }
}
