<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class SetLocale
{

    /**
     * Handle an incoming request.
     *
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Session::has('locale') && in_array(Session::get('locale'), ['en', 'ar'])) {
            App::setLocale(Session::get('locale'));
        } else {
            App::setLocale(Config::get('app.fallback_locale'));
        }

        return $next($request);
    }
}
