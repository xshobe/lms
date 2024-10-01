<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('admin/login');
            }
        }
        //Auth::user()->Role->role_name!='Admin' &&
        if (!empty(Auth::user()->Role->privileges->actions)) {
            $Url_array = array();
            $menu_links = Config::get('constants.menu_links');
            $action = unserialize(Auth::user()->Role->privileges->actions);


            if ($action) {
                foreach ($action as $menu_id) {
                    if (!empty($menu_links[$menu_id]['controller'])) {
                        $Url_array[$menu_id] = $menu_links[$menu_id]['controller'];
                    }
                }

                //pr($Url_array);
                //exit;

                if (!in_array($this->getCurrentControllerName(), $Url_array)) {
                    abort(403, 'Access denied');
                }
            }
        }
        return $next($request);
    }

    public function getCurrentControllerName()
    {
        list($list_controller, $action) = explode('@', Route::currentRouteAction());
        $replace_controller = str_replace('\\', '/', $list_controller);
        $x = list(, $controller) = explode('App/Http/Controllers/', $replace_controller);
        return $controller;
    }
}
