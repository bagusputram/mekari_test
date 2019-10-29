<?php

namespace App\Http\Middleware;
use Illuminate\Session\Store;
use App\Models\Setting\SessionTimeout;

use Auth;
use Carbon\Carbon;
use App\User;

use Closure;

class SessionTimeoutMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    protected $session;

    public function __construct(Store $session){
        $this->session = $session;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
                
        $user = Auth::user();
        
        if( $user == null ) {
            $this->logout($request);
            if( $request->ajax() ) {
                return response()->json(['message' => 'Session expired'], 403);
            } else {
                //$cookie = cookie('intend', $isLoggedIn ? url()->current() : 'dashboard');
                return redirect()->route('login')->with('msg', __('message.no_activity') . '<br>' . __('message.for_system_security') );
            }
        }
        $lastActive = Carbon::parse($user->auth_last_login);
        $now = Carbon::now();

        if( $lastActive->diffInSeconds($now) > SessionTimeout::find(1)->session_timeout && SessionTimeout::find(1)->session_timeout != 0) {
            $this->logout($request);
            if( $request->ajax() ) {
                return response()->json(['message' => 'Session expired'], 403);
            } else {
                //$cookie = cookie('intend', $isLoggedIn ? url()->current() : 'dashboard');
                return redirect()->route('login')->with('msg', __('message.no_activity') . '<br>' . __('message.for_system_security') );
            }
        }

        return $next($request);
    }

    private function logout($request) {
        try {
            auth()->logout();
        } catch( Exception $e ) {
            
        } 
        //$this->guard()->logout();
        $request->session()->invalidate();
    }
}
