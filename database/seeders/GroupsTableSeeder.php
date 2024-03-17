<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\GroupHasAccess;
use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GroupHasAccess::truncate();
        Group::truncate();

        $groups = ['super_admins', 'employees'];

        foreach ($groups as $index => $group_individual) {
            $group_response = Group::create([
                'slug'        => strtoupper(substr(md5(uniqid(rand(), true)), 0, 5)),
                'name'        => ucwords(str_replace('_', ' ', $group_individual)),
                'description' => ucwords(str_replace('_', ' ', $group_individual)) . '... Description',
                'is_active'   => 1,
            ]);

            if (in_array($index, [0, 1])) {
                $prepared_system_modules = config('policies');

                if (!empty($prepared_system_modules)) {
                    foreach ($prepared_system_modules as $grand_parent => $parents) {
                        if (!empty($parents)) {
                            foreach ($parents as $parent => $children) {
                                if (!empty($children)) {
                                    foreach ($children as $child) {
                                        GroupHasAccess::create([
                                            'group_id' => $group_response->id,
                                            'module'   => $child,
                                            'access'   => 1
                                        ]);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
