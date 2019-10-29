<?php

namespace App\Http\Middleware;

use Closure;

use Auth;
use Route;

use App\User;
use App\Models\Setting\RouteList;
use App\Models\Setting\UserMenuPermission;

class UserMenuPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $currentRouteName       = Route::currentRouteName();
        $user_role_id           = Auth::user()->user_role_id;

        $routeList              = RouteList::where('route_menu_name',Route::currentRouteName())->first();

        $user_menu_permission   = UserMenuPermission::where('menu_id',$routeList->menu_id)->where('menu_type_id',$routeList->menu_type_id)->where('user_role_id',$user_role_id)->first();

        if(!$user_menu_permission || $user_menu_permission->permission == 'false'){
            return redirect()->back()->with('denied','denied');
        }
        else {
            return $next($request);
        }
    }
}
