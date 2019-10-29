<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Excel;

use App\Models\Setting\Citizenship;
use App\Models\Setting\Menu;
use App\Models\Setting\MenuType;
use App\Models\Setting\UserMenuPermission;
use App\Models\Setting\UserRole;

use App\Libraries\Hashid\Hasher;

class UserMenuPermissionController extends Controller
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu_types             = MenuType::all();
        $menus                  = Menu::all();
        $user_role              = UserRole::where('id',$id[0])->get();
        $user_menu_permissions  = UserMenuPermission::where('user_role_id',$id[0])->where('permission','true')->get();
        $is_true                = [];

        foreach($user_menu_permissions as $user_menu_permission){
            $is_true[]    = $user_menu_permission->menuName->menu_language.'.'.$user_menu_permission->menuTypeName->name;
        }

        return view('pages.manage-setting.user-menu-permission.edit',compact('menu_types','menus','user_role','is_true'));
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
        $menu_types             = MenuType::all();
        $menus                  = Menu::all();
        $menu_routes            = [];

        foreach($menus as $menu){
            foreach($menu_types as $menu_type){
                $menu_routes[]     = $menu->menu_language.'.'.$menu_type->name;
            }
        }

        if($request->has('permission')){
            foreach($request->input('permission') as $input){
                if(in_array($input,$menu_routes)){
                    $input_explode  = explode('.',$input);

                    $menu_name_language = $input_explode[0];
                    $menu_type_name     = $input_explode[1];

                    $menu               = Menu::where('menu_language',$menu_name_language)->first();
                    $menu_type          = MenuType::where('name',$menu_type_name)->first();

                    $user_menu_permissions = UserMenuPermission::updateOrCreate(
                        ['user_role_id' => $id[0], 'menu_id' => $menu->id, 'menu_type_id' => $menu_type->id],
                        ['permission' => 'true']
                    );

                    $key = array_search($input, $menu_routes);
                    unset($menu_routes[$key]);
                }
            }
        }

        foreach($menu_routes as $menu_route){
            $menu_route_explode  = explode('.',$menu_route);

            $menu_id            = $menu_route_explode[0];
            $menu_type_id       = $menu_route_explode[1];

            $menu               = Menu::where('menu_language',$menu_id)->first();
            $menu_type          = MenuType::where('name',$menu_type_id)->first();

            $user_menu_permissions = UserMenuPermission::updateOrCreate(
                ['user_role_id' => $id[0], 'menu_id' => $menu->id, 'menu_type_id' => $menu_type->id],
                ['permission' => 'false']
            );
            $key = array_search($menu_route, $menu_routes);
            unset($menu_routes[$key]);
        }

        $user_role              = UserRole::where('id',$id[0])->get();

        return redirect('/setting/user-menu-permission/'.$user_role[0]->hashid.'/edit')->with('success', 'edit');;
    }
}
