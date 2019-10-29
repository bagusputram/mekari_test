<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

use App\Models\Setting\ApplicationLanguage;

class SetApplicationLanguage
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
        \App::setLocale('en');

        if( Auth::user() ){
            $user_id    = Auth::user()->id;
        }
        
        $lang       = 'en';

        if( !empty($user_id) ){
            $user_profile   = \App\Models\Setting\UserProfile::where('user_id',$user_id)->first();
            if( !empty($user_profile)){
                $lang           = $user_profile->applicationLanguageId->language_id;
                \App::setLocale( $lang );
            }            
        }

        return $next($request);
    }
}
