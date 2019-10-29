<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Validator;

use Carbon\Carbon;

use App\Libraries\Hashid\Hasher;

use App\User;
use App\Models\Setting\Language;
use App\Models\Setting\ApplicationThemeColor;
use App\Models\Setting\UserProfile;

class UserProfileController extends Controller
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
    public function index(Request $request)
    {
        $user_id                            = Auth::user()->id;
        $user_profile                       = UserProfile::where('user_id',$user_id)->first();

        if(empty($user_profile)){
            $user_profile_create                            = new UserProfile;
            $user_profile_create->user_id                   = 1;
            $user_profile_create->application_language      = 1;
            $user_profile_create->application_theme_color   = 1;
            $user_profile_create->save();
        }

        $user_profile                       = UserProfile::where('user_id',$user_id)->first();
        $languages                          = Language::all();
        $application_theme_colors           = ApplicationThemeColor::all();

        return view('pages.manage-setting.user-application-profile.index',compact('user_profile','languages','application_theme_colors'));
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
            'application_language'       => 'required',
            'application_theme_color'    => 'required',
        ]);

        if ( $validator->fails() ) {
            return redirect('setting/user-application-profile')->withErrors($validator)->withInput();
        }

        $user_profile                               = UserProfile::find($id[0]);

        $user_profile->application_language         = $request->application_language;
        $user_profile->application_theme_color      = $request->application_theme_color;

        $user_profile->save();

        return redirect('setting/user-application-profile')->with('success', 'edit');
    }
}
