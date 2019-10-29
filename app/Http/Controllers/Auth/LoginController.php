<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Eperformance\DataMaster\Pejabat;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use App\User;

use Carbon\Carbon;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        attemptLogin as attemptLoginAtAuthenticatesUsers;
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Returns field name to use at login.
     *
     * @return string
     */
    public function username()
    {
        return config('auth.providers.users.field', 'email');
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        if ($this->username() === 'email') {
            User::where('email', $request->email)->update([
                'auth_last_login' => new Carbon
            ]);

            return $this->attemptLoginAtAuthenticatesUsers($request);
        }
        else {
            User::where('email', $request->email)->update([
                'auth_last_login' => new Carbon
            ]);

            return $this->attempLoginUsingUsernameAsAnEmail($request);
        }
        return false;
    }

    /**
     * Attempt to log the user into application using username as an email.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function attempLoginUsingUsernameAsAnEmail(Request $request)
    {
        User::where('email', $request->input('username'))->update([
            'auth_last_login' => new Carbon
        ]);

        // user data
        $user = User::where('email', $request->input('username'))->first();
        // checker if login using email
        if( !empty($user)){
            // checker user role if superadministrator skip checker
            if( $user->user_role_id == 1){
                // login
                $email = $this->guard()->attempt(
                    ['email' => $request->input('username'), 'password' => $request->input('password')],
                    $request->has('remember')
                );
            } else {
                // if pejabat login and not active
                if( Pejabat::where('user_id', $user->id)->first()->pejabat_is_active == 0 ){
                    return false;
                } else {
                    // login
                    $email      = $this->guard()->attempt(
                        ['email' => $request->input('username'), 'password' => $request->input('password')],
                        $request->has('remember')
                    );
                }
            }
        } else {
            User::where('username', $request->input('username'))->update([
                'auth_last_login' => new Carbon
            ]);

            // user data
            $username = User::where('username', $request->input('username'))->first();
            // checker user role if superadministrator skip checker
            if( $username->user_role_id == 1){
                $email = $this->guard()->attempt(
                    ['username' => $request->input('username'), 'password' => $request->input('password')],
                    $request->has('remember')
                );
            } else {
                // if pejabat login and not active
                if( Pejabat::where('user_id', $username->id)->first()->pejabat_is_active == 0 ){
                    return false;
                } else {
                    // login
                    $email = $this->guard()->attempt(
                        ['username' => $request->input('username'), 'password' => $request->input('password')],
                        $request->has('remember')
                    );
                }
            }
        }
        return $email;
    }
}
