<?php

namespace App\Http\Controllers;

use Auth;
use Validator;

use Illuminate\Http\Request;

use App\Libraries\Hashid\Hasher;

use App\User;

class UserEditAuthenticationController extends Controller
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


    public function edit()
    {       
        $user             = Auth::user();        

        return view('pages.manage-setting.edit-user-data-authentication.edit',compact('user'));
    }

    public function update(Request $request, $id)
    {
        if(!empty($request->password)){
            $validator = Validator::make($request->all(), [        
                'name'     => 'required|max:255',
                'password' => 'required|min:6|confirmed',            
            ]);        

            if ( $validator->fails() ) {
                return redirect('setting/edit-user-data-authentication')->withErrors($validator)->withInput();
            }

            $user               = User::find($id[0]);

            $user->name         = $request->name;
            $user->password     = bcrypt($request->password);
                    
            $user->save();

            return redirect('setting/edit-user-data-authentication')->with('success', 'edit');
        } else {
            $validator = Validator::make($request->all(), [        
                'name'     => 'required|max:255',                
            ]);        

            if ( $validator->fails() ) {
                return redirect('setting/edit-user-data-authentication')->withErrors($validator)->withInput();
            }

            $user               = User::find($id[0]);

            $user->name         = $request->name;
                    
            $user->save();

            return redirect('setting/edit-user-data-authentication')->with('success', 'edit');
        }

        
    }
}
