<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Route;
use Validator;
use Excel;

use App\Models\Setting\Menu;
use App\Models\Setting\UserMenuPermission;
use App\Models\Setting\UserRole;

use App\Libraries\Hashid\Hasher;
use App\Models\Setting\RouteList;

class MenuController extends Controller
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

        $is_trash               = $request->get('status') == 'trash' ? true : false;

        $menus                  = Menu::all();
        $menu_count             = $menus->count();
        $user_roles             = UserRole::all();
        $trash                  = Menu::onlyTrashed()->orderBy("deleted_at", "desc");

        $user_menu_permissions  = GetUserButtonPermission($user_role_id,$currentRouteName);

        foreach($user_menu_permissions as $user_menu_permission){
            $allowed_button[]   = $user_menu_permission->menuTypeName->name;
        }

        if ( $is_trash ) {
            $menus = $trash->get();
        }

        return view('pages.manage-setting.menu.index', compact('menus', 'menu_count', 'user_roles', 'trash','allowed_button'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menus          = Menu::all();
        $user_roles     = UserRole::all();

        return view('pages.manage-setting.menu.create',compact('menus','user_roles'));
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
            'menu_name'         => 'required',
            'menu_icon'         => 'required',
            'menu_language'     => 'required',
            'menu_controller'   => 'required',
            'menu_position'     => 'required',
            'user_role_id'      => 'required',
        ]);

        if ( $validator->fails() ) {
            return redirect('setting/menu')->withErrors($validator)->withInput();
        }

        // $last_menu              = Menu::where('menu_position',$request->menu_position)->where('menu_parent_id',$request->menu_parent_id)->first();
        // $max                    = Menu::where('menu_parent_id',$request->menu_parent_id)->max('menu_position');

        // if($last_menu){
        //     $new_menu_position          = $last_menu->menu_position;
        //     $last_menu->menu_position   = $max+1;

        //     $last_menu->save();
        // }

        $menu                   = new Menu;

        $menu->menu_name        = $request->menu_name;
        $menu->menu_icon        = $request->menu_icon;
        $menu->menu_language    = $request->menu_language;
        $menu->menu_controller  = $request->menu_controller;
        $menu->menu_position    = $request->menu_position;
        $menu->menu_parent_id   = ($request->menu_parent_id != null) ? (int)$request->menu_parent_id : 0;
        $menu->user_role_id     = json_encode($request->user_role_id);


        $menu->save();

        return redirect('setting/menu')->with('success', 'create');;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu           = Menu::find($id[0]);
        $menus          = Menu::All();
        $user_roles     = UserRole::All();

        return view('pages.manage-setting.menu.edit', compact('menus','user_roles','menu'));
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
            'menu_name'         => 'required',
            'menu_icon'         => 'required',
            'menu_language'     => 'required',
            'menu_controller'   => 'required',
            'menu_position'     => 'required',
            'user_role_id'      => 'required',
        ]);

        if ( $validator->fails() ) {
            return redirect('setting/menu/' . $id . '/edit')->withErrors($validator)->withInput();
        }

        // $last_menu              = Menu::where('menu_position',$request->menu_position)->where('menu_parent_id',$request->menu_parent_id)->first();
        $menu                   = Menu::find($id[0]);

        // if($last_menu){
        //     $new_menu_position          = $last_menu->menu_position;
        //     $last_menu->menu_position   = $menu->menu_position;

        //     $last_menu->save();
        // }

        $menu->menu_name        = $request->menu_name;
        $menu->menu_icon        = $request->menu_icon;
        $menu->menu_language    = $request->menu_language;
        $menu->menu_controller  = $request->menu_controller;
        $menu->menu_position    = $request->menu_position;
        $menu->menu_parent_id   = ($request->menu_parent_id != null) ? (int)$request->menu_parent_id : 0;
        $menu->user_role_id     = json_encode($request->user_role_id);        

        $menu->save();

        return redirect('setting/menu')->with('success', 'edit');
    }

    /**
     * Delete Level
     *
     * @return void
     */
    public function delete($id) {
        $menu = Menu::find($id[0]);
        $menu->delete();

        return redirect('setting/menu')->with('delete' ,'delete');
    }

    /**
     * Restore Level data
     *
     * @return void
     */
    public function restore($id) {
        // restore menu by id
        Menu::onlyTrashed()->where('id', $id[0])->restore();
        // restore routelist by menu_id
        RouteList::onlyTrashed()->where('menu_id',$id[0])->restore();
        // restrore usermenupermission by menu_id
        UserMenuPermission::onlyTrashed()->where('menu_id',$id[0])->restore();

        return redirect('setting/menu')->with('restore', 'restore');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Menu::onlyTrashed()->where('id', $id[0])->forceDelete();

        return redirect('setting/menu')->with('delete', 'delete');
    }

    public function import(Request $request) {

        if ($request->hasFile('file_import')) {
            $path = $request->file('file_import')->getRealPath();
            $data = Excel::load($path, function ($render){})->get();

            if (!empty($data) && $data->count()) {
                $insert = array();

                foreach ( $data as $key => $value ) {

                    $insert['gender_name']           = $value->gender_name ?? null;

                    Gender::create($insert);
                }
            }
        }

        return redirect('setting/menu')->with('success', 'create');

    }

    public function export(){
        $data[] = [
            'name' => null,
        ];

        Excel::create('ris-gender-import', function($excel) use ($data) {
        $excel->sheet('Gender', function($sheet) use ($data) {
            $sheet->fromArray($data);
        });

        })->download('xlsx');

    }
}
