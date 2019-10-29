<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use View;

use App\Models\Setting\ApplicationLanguage;

class SetApplicationThemeColorMiddleware
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
        $skin   = 'skin-blue';

        if( Auth::user() ){
            $user_id    = Auth::user()->id;
        }        

        if( !empty($user_id) ){
            $user_profile   = \App\Models\Setting\UserProfile::where('user_id',$user_id)->first();
            if( !empty($user_profile)){
                $skin           = $user_profile->applicationThemeColorCode->code;                
            }            
        }

        View::share('skin', $skin);

        return $next($request);
    }
}
