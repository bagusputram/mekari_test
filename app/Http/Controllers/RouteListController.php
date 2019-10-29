<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Excel;

use App\Models\Setting\Menu;
use App\Models\Setting\MenuType;
use App\Models\Setting\RouteControllerType;
use App\Models\Setting\RouteList;
use App\Models\Setting\RouteType;

use App\Imports\RouteListImport;
use App\Exports\Template\RouteListExportTemplate;

use App\Libraries\Hashid\Hasher;

class RouteListController extends Controller
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

        $route_lists                = RouteList::all();
        $route_list_count           = $route_lists->count();
        $trash                      = RouteList::onlyTrashed()->orderBy("deleted_at", "desc");
        $route_types                = RouteType::all();
        $route_controller_types     = RouteControllerType::all();
        $menus                      = Menu::all();
        $menu_types                 = MenuType::all();


        if ( $is_trash ) {
            $route_lists = $trash->get();
        }

        return view('pages.manage-setting.route-list.index', compact('route_lists', 'route_list_count', 'trash','route_types','route_controller_types','menus','menu_types'));
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
            'name'                          => 'required',
            'route_type_id'                 => 'required',
            'route_controller_type_id'      => 'required',
            'route_controller_name'         => 'required',
            'route_menu_name'               => 'required',
            'menu_type_id'                  => 'required',
            'menu_id'                       => 'required',
            'route_link'                    => 'required',
        ]);

        if ( $validator->fails() ) {
            return redirect('setting/route-list')->withErrors($validator)->withInput();
        }

        $route_list                             = new RouteList;

        $route_list->name                       = $request->name;
        $route_list->route_type_id              = $request->route_type_id;
        $route_list->route_controller_type_id   = $request->route_controller_type_id;
        $route_list->route_controller_name      = $request->route_controller_name;
        $route_list->route_menu_name            = $request->route_menu_name;
        $route_list->menu_type_id               = $request->menu_type_id;
        $route_list->menu_id                    = $request->menu_id;
        $route_list->route_link                 = $request->route_link;

        $route_list->save();

        return redirect('setting/route-list')->with('success', 'create');;
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
            'name'                          => 'required',
            'route_type_id'                 => 'required',
            'route_controller_type_id'      => 'required',
            'route_controller_name'         => 'required',
            'route_menu_name'               => 'required',
            'menu_type_id'                  => 'required',
            'menu_id'                       => 'required',
            'route_link'                    => 'required',
        ]);

        if ( $validator->fails() ) {
            return redirect('setting/route-list/' . $id . '/edit')->withErrors($validator)->withInput();
        }

        $route_list                             = RouteList::find($id[0]);

        $route_list->name                       = $request->name;
        $route_list->route_type_id              = $request->route_type_id;
        $route_list->route_controller_type_id   = $request->route_controller_type_id;
        $route_list->route_controller_name      = $request->route_controller_name;
        $route_list->route_menu_name            = $request->route_menu_name;
        $route_list->menu_type_id               = $request->menu_type_id;
        $route_list->menu_id                    = $request->menu_id;
        $route_list->route_link                 = $request->route_link;

        $route_list->save();

        return redirect('setting/route-list')->with('success', 'edit');
    }

    /**
     * Delete Menu Type
     *
     * @return void
     */
    public function delete($id)
    {
        $route_list = RouteList::find($id[0]);
        $route_list->delete();

        return redirect('setting/route-list')->with('delete' ,'delete');
    }

    /**
     * Restore Menu Type data
     *
     * @return void
     */
    public function restore($id)
    {

        RouteList::onlyTrashed()->where('id', $id[0])->restore();

        return redirect('setting/route-list')->with('restore', 'restore');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        RouteList::onlyTrashed()->where('id', $id[0])->forceDelete();

        return redirect('setting/route-list')->with('delete', 'delete');
    }

    public function import(Request $request) {

        //dd($request->file('file_import')->getRealPath());

        if ($request->hasFile('file_import')) {

            $path = $request->file('file_import');

            Excel::import(new RouteListImport, $path);

            return redirect('setting/route-list')->with('success', 'create');

        }
        else {
            return redirect('setting/route-list')->with('failed', 'failed');
        }

    }

    public function export()
    {
        return Excel::download(new RouteListExportTemplate, 'ris-route-list-import.xlsx');
    }
}
