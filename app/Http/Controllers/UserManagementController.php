<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use Route;
use Auth;
use Excel;

use App\User;
use App\Models\Setting\UserRole;

use App\Libraries\Hashid\Hasher;

class UserManagementController  extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $currentRouteName       = Route::currentRouteName();
        $user_role_id           = Auth::user()->user_role_id;

        $users                  = User::all();
        $user_count             = $users->count();
        $user_roles             = UserRole::all();

        $user_menu_permissions  = GetUserButtonPermission($user_role_id,$currentRouteName);

        foreach($user_menu_permissions as $user_menu_permission){
            $allowed_button[]   = $user_menu_permission->menuTypeName->name;
        }

        return view('pages.user-management.index', compact('users', 'user_count', 'allowed_button','user_roles'));
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
            'name'     => 'required|max:255',
            'username' => 'sometimes|required|max:255|unique:users',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        if ( $validator->fails() ) {
            return redirect('user-management')->withErrors($validator)->withInput();
        }

        $user               = new User;

        $user->name         = $request->name;
        $user->email        = $request->email;
        $user->username     = $request->username;
        $user->password     = bcrypt($request->password);
        $user->user_role_id = $request->user_role_id;

        $user->save();

        return redirect('user-management')->with('success', 'edit');
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
        if(!empty($request->password)){
            $validator = Validator::make($request->all(), [
                'name'     => 'required|max:255',
                'username' => 'sometimes|required|max:255',
                'email'    => 'required|email|max:255',
                'password' => 'required|min:6|confirmed',
            ]);

            if ( $validator->fails() ) {
                return redirect('user-management')->withErrors($validator)->withInput();
            }

            $user               = User::find($id[0]);

            $user->name         = $request->name;
            $user->email        = $request->email;
            $user->username     = $request->username;
            $user->password     = bcrypt($request->password);
            $user->user_role_id = $request->user_role_id;

            $user->save();

            return redirect('user-management')->with('success', 'edit');
        } else {
            $validator = Validator::make($request->all(), [
                'name'     => 'required|max:255',
                'username' => 'sometimes|required|max:255',
                'email'    => 'required|email|max:255',
            ]);

            if ( $validator->fails() ) {
                return redirect('user-management')->withErrors($validator)->withInput();
            }

            $user               = User::find($id[0]);

            $user->name         = $request->name;
            $user->email        = $request->email;
            $user->username     = $request->username;
            $user->user_role_id = $request->user_role_id;

            $user->save();

            return redirect('user-management')->with('success', 'edit');
        }
    }

    // public function import(Request $request) {

    //     if ($request->hasFile('file_import')) {
    //         $path = $request->file('file_import')->getRealPath();
    //         $data = Excel::load($path, function ($render){})->get();

    //         if (!empty($data) && $data->count()) {
    //             $insert = array();

    //             foreach ( $data as $key => $value ) {

    //                 $insert['gender_name']           = $value->gender_name ?? null;

    //                 Gender::create($insert);
    //             }
    //         }
    //     }

    //     return redirect('setting/gender')->with('success', 'create');

    // }

    // public function export(){
    //     $data[] = [
    //         'gender_name' => null,
    //     ];

    //     Excel::create('ris-gender-import', function($excel) use ($data) {
    //     $excel->sheet('Gender', function($sheet) use ($data) {
    //         $sheet->fromArray($data);
    //     });

    //     })->download('xlsx');

    // }
}
