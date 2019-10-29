<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\Models\Setting\SessionTimeout;

use App\Libraries\Hashid\Hasher;

use App\User;

class SessionTimeoutController extends Controller
{
    /**
	 * Hasher class variable
	 * @var Hasher
	 */
    private $hasher;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware(['auth','user.permission']);
        $this->hasher = new Hasher();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'session_timeout'   => 'required',
        ]);

        if ( $validator->fails() ) {
            return redirect('setting/restricted-setting/')->withErrors($validator)->withInput();
        }

        $session_timeout                    = new SessionTimeout;

        $session_timeout->session_timeout   = $request->session_timeout;

        $session_timeout->save();

        return redirect('setting/restricted-setting/')->with('success', 'create');;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'session_timeout'       => 'required',
        ]);

        if ( $validator->fails() ) {
            return redirect('setting/restricted-setting/')->withErrors($validator)->withInput();
        }

        $session_timeout                     = SessionTimeout::find($id[0]);

        $session_timeout->session_timeout    = $request->session_timeout;

        $session_timeout->save();

        return redirect('setting/restricted-setting/')->with('success', 'edit');
    }
}
