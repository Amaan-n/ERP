<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Spatie\Activitylog\Models\Activity;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application designs.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application designs.
     *
     * @return void
     */
    public function boot()
    {
        //        \Illuminate\Support\Facades\URL::forceScheme('https');

        view()->composer('*', function ($view) {

            $accesses_urls = [];
            $user_group    = '';
            $is_root_user  = 0;

            if (auth()->check()) {
                $user_group          = auth()->user()->group;
                $user_group_accesses = isset($user_group) && !empty($user_group) ? $user_group->accesses : [];
                if (isset($user_group_accesses) && !empty($user_group_accesses)) {
                    foreach ($user_group_accesses as $access) {
                        $accesses_urls[] = $access->module;
                    }
                }
                $is_root_user = auth()->user()->is_root_user && auth()->user()->is_root_user > 0 ? 1 : 0;
            }

            //...with this variable
            $view->with('is_root_user', $is_root_user);
            $view->with('user_group', $user_group);
            $view->with('accesses_urls', $accesses_urls);

            $configuration = get_configurations_data();
            $view->with('configuration', $configuration);
        });

        require_once app_path() . '/Helpers/helpers.php';
        Schema::defaultStringLength(191);

         //Saving the IPs for all the users who are Performing CRUD 
         Activity::saving(function (Activity $activity) {
            $activity->properties = $activity->properties->put('ip', request()->ip());
        });
    }
}
