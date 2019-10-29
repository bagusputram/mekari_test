<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Validator;

use App\Libraries\Hashid\Hasher;
use App\Models\Setting\UserProfile;


class UserProfilePictureController extends Controller
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
        $this->hasher = new Hasher();
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
        // get user id from input data
        $user_profile                       = UserProfile::find($id[0]);

        // uploaded profile picture
        $uploaded_file = $user_profile->addMediaFromRequest('userFile')->toMediaCollection('profile-picture');

        // update user profile picture
        $user_profile->profile_picture_id   = $uploaded_file->id;

        $user_profile->save();

        return redirect('setting/user-application-profile')->with('success', 'edit');
    }
}
