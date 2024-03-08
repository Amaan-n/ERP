<?php

namespace App\Providers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Support\ServiceProvider;

class FormList extends ServiceProvider
{
    public static function getUsers()
    {
        return User::where('is_active', 1)->get();
    }

    public static function getAuthors()
    {
        return User::where('is_active', 1)->where('group_id', 2)->get();
    }

    public static function getGroups()
    {
        return Group::where('is_active', 1)->get();
    }
}
