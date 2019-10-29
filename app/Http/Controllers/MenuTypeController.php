<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Excel;

use App\Models\Setting\MenuType;

use App\Libraries\Hashid\Hasher;

class MenuTypeController extends Controller
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

        $menu_types         = MenuType::all();
        $menu_type_count    = $menu_types->count();
        $trash              = MenuType::onlyTrashed()->orderBy("deleted_at", "desc");        

        if ( $is_trash ) {
            $menu_types = $trash->get();
        }        

        return view('pages.manage-setting.menu-type.index', compact('menu_types', 'menu_type_count', 'trash'));
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
            'name'       => 'required',            
        ]);
        
        if ( $validator->fails() ) {
            return redirect('setting/menu-type')->withErrors($validator)->withInput();
        }

        $menu_type          = new MenuType;
        
        $menu_type->name    = $request->name;        
        
        $menu_type->save();

        return redirect('setting/menu-type')->with('success', 'create');;
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
            'name'       => 'required',            
        ]);        

        if ( $validator->fails() ) {
            return redirect('setting/menu-type/' . $id . '/edit')->withErrors($validator)->withInput();
        }

        $menu_type          = MenuType::find($id[0]);        

        $menu_type->name    = $request->name;
        
        $menu_type->save();

        return redirect('setting/menu-type')->with('success', 'edit');
    }

    /**
     * Delete Menu Type
     *
     * @return void
     */
    public function delete($id) 
    {        
        $menu_type = MenuType::find($id[0]);        
        $menu_type->delete();

        return redirect('setting/menu-type')->with('delete' ,'delete');
    }

    /**
     * Restore Menu Type data
     *
     * @return void
     */
    public function restore($id) 
    {
        
        MenuType::onlyTrashed()->where('id', $id[0])->restore();

        return redirect('setting/menu-type')->with('restore', 'restore');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MenuType::onlyTrashed()->where('id', $id[0])->forceDelete();

        return redirect('setting/menu-type')->with('delete', 'delete');
    }

    public function import(Request $request) {

        if ($request->hasFile('file_import')) {
            $path = $request->file('file_import')->getRealPath();
            $data = Excel::load($path, function ($render){})->get();

            if (!empty($data) && $data->count()) {
                $insert = array();

                foreach ( $data as $key => $value ) {

                    $insert['name']           = $value->name ?? null;

                    MenuType::create($insert);          
                }
            }
        }

        return redirect('setting/menu-type')->with('success', 'create');

    }

    public function export(){
        $data[] = [      
            'name' => null,
        ];

        Excel::create('ris-menu-type-import', function($excel) use ($data) {
        $excel->sheet('Menu Type', function($sheet) use ($data) {
            $sheet->fromArray($data);
        });

        })->download('xlsx');

    }
}
