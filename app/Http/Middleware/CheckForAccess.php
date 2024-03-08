<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;

class CheckForAccess
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            if (session()->get('is_locked') === true) {
                if (!in_array($request->route()->getName(), ['auth.lock', 'auth.unlock', 'logout'])) {
                    return redirect()->route('auth.lock');
                }
            }
        }

        $system_modules    = config('policies');
        $protected_modules = [];
        foreach ($system_modules as $module) {
            foreach ($module as $module_value) {
                if (!empty($module_value)) {
                    foreach ($module_value as $value) {
                        $protected_modules[] = $value;
                    }
                }
            }
        }

        $exclude_bypass_array = ['home', 'dashboard', 'profile'];

        $accesses_urls = [];
        if (auth()->check()) {
            $user_group          = auth()->user()->group;
            $user_group_accesses = isset($user_group) && !empty($user_group) && !empty($user_group->accesses) ? $user_group->accesses : '';
            if (isset($user_group_accesses) && !empty($user_group_accesses)) {
                foreach ($user_group_accesses as $access) {
                    $accesses_urls[] = $access->module;
                }
            }
        }

        if (isset(auth()->user()->is_root_user)
            && auth()->user()->is_root_user == 0
            && in_array($request->route()->getName(), $protected_modules)
            && !in_array($request->route()->getName(), $accesses_urls)
            && !in_array($request->route()->getName(), $exclude_bypass_array)) {
            return redirect()->route('401');
        }

        return $next($request);
    }
}
