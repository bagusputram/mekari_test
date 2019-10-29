<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Excel;

use App\Models\Setting\UserRole;

use App\Libraries\Hashid\Hasher;

class UserRoleController extends Controller
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
        $is_trash = $request->get('status') == 'trash' ? true : false;

        $user_roles         = UserRole::all();
        $user_role_count    = $user_roles->count();
        $trash              = UserRole::onlyTrashed()->orderBy("deleted_at", "desc");
        $create             = true;
        $edit               = false;

        if ( $is_trash ) {
            $user_roles = $trash->get();
        }        

        return view('pages.manage-setting.user-role.index', compact('user_roles', 'user_role_count', 'trash','create','edit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.manage-setting.user-role.create');
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
            'user_role_name'    => 'required',
            'description'   => 'required',
            'user_role_bypass'   => 'required',
        ]);
        
        if ( $validator->fails() ) {
            return redirect('setting/user-role')->withErrors($validator)->withInput();
        }

        $user_role                      = new UserRole;

        $user_role->user_role_name = $request->user_role_name;
        $user_role->description = $request->description;
        $user_role->user_role_bypass = $request->user_role_bypass;
        
        $user_role->save();

        return redirect('setting/user-role')->with('success', 'create');;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {        
        $user_roles         = UserRole::all();
        $user_role_count    = $user_roles->count();
        $trash              = UserRole::onlyTrashed()->orderBy("deleted_at", "desc");
        
        $user_role          = UserRole::find($id[0]);
        $edit               = true;
        $create             = false;
        
        return view('pages.manage-setting.user-role.index', compact('user_roles','user_role_count','trash','user_role','edit','create'));
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
            'user_role_name'    => 'required',
            'description'       => 'required',
            'user_role_bypass'   => 'required',
        ]);        

        if ( $validator->fails() ) {
            return redirect('setting/user-role/' . $id . '/edit')->withErrors($validator)->withInput();
        }

        $user_role                      = UserRole::find($id[0]);

        $user_role->user_role_name = $request->user_role_name;
        $user_role->description = $request->description;
        $user_role->user_role_bypass = $request->user_role_bypass;
        
        $user_role->save();

        return redirect('setting/user-role')->with('success', 'edit');
    }

    /**
     * Delete Level
     *
     * @return void
     */
    public function delete($id) {        
        $user_role = UserRole::find($id[0]);        
        $user_role->delete();

        return redirect('setting/user-role')->with('delete' ,'delete');
    }

    /**
     * Restore Level data
     *
     * @return void
     */
    public function restore($id) {
        
        UserRole::onlyTrashed()->where('id', $id[0])->restore();

        return redirect('setting/user-role')->with('restore', 'restore');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UserRole::onlyTrashed()->where('id', $id[0])->forceDelete();

        return redirect('setting/user-role')->with('delete', 'delete');
    }

    public function import(Request $request) {

        if ($request->hasFile('file_import')) {
            $path = $request->file('file_import')->getRealPath();
            $data = Excel::load($path, function ($render){})->get();

            if (!empty($data) && $data->count()) {
                $insert = array();

                foreach ( $data as $key => $value ) {

                    $insert['user_role_name']   = $value->user_role_name ?? null;
                    $insert['description']      = $value->description ?? null;

                    UserRole::create($insert);          
                }
            }
        }

        return redirect('setting/user-role')->with('success', 'create');

    }

    public function export(){
        $data[] = [      
            'user_role_name' => null,
            'description'    => null,
        ];

        Excel::create('ris-user-role-import', function($excel) use ($data) {
        $excel->sheet('User Role', function($sheet) use ($data) {
            $sheet->fromArray($data);
        });

        })->download('xlsx');

    }
}
