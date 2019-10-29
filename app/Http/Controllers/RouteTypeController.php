<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Excel;

use App\Models\Setting\RouteType;

use App\Libraries\Hashid\Hasher;

class RouteTypeController extends Controller
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

        $route_types        = RouteType::all();
        $route_type_count   = $route_types->count();
        $trash              = RouteType::onlyTrashed()->orderBy("deleted_at", "desc");        

        if ( $is_trash ) {
            $route_types = $trash->get();
        }        

        return view('pages.manage-setting.route-type.index', compact('route_types', 'route_type_count', 'trash'));
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
            return redirect('setting/route-type')->withErrors($validator)->withInput();
        }

        $route_type         = new RouteType;
        
        $route_type->name   = $request->name;        
        
        $route_type->save();

        return redirect('setting/route-type')->with('success', 'create');;
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
            return redirect('setting/route-type/' . $id . '/edit')->withErrors($validator)->withInput();
        }

        $route_type         = RouteType::find($id[0]);        

        $route_type->name   = $request->name;
        
        $route_type->save();

        return redirect('setting/route-type')->with('success', 'edit');
    }

    /**
     * Delete Route Type
     *
     * @return void
     */
    public function delete($id) {        
        $route_type = RouteType::find($id[0]);        
        $route_type->delete();

        return redirect('setting/route-type')->with('delete' ,'delete');
    }

    /**
     * Restore Route Type data
     *
     * @return void
     */
    public function restore($id) {
        
        RouteType::onlyTrashed()->where('id', $id[0])->restore();

        return redirect('setting/route-type')->with('restore', 'restore');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        RouteType::onlyTrashed()->where('id', $id[0])->forceDelete();

        return redirect('setting/route-type')->with('delete', 'delete');
    }

    public function import(Request $request) {

        if ($request->hasFile('file_import')) {
            $path = $request->file('file_import')->getRealPath();
            $data = Excel::load($path, function ($render){})->get();

            if (!empty($data) && $data->count()) {
                $insert = array();

                foreach ( $data as $key => $value ) {

                    $insert['name']           = $value->name ?? null;

                    RouteType::create($insert);          
                }
            }
        }

        return redirect('setting/route-type')->with('success', 'create');

    }

    public function export(){
        $data[] = [      
            'name' => null,
        ];

        Excel::create('ris-name-import', function($excel) use ($data) {
        $excel->sheet('Route Type', function($sheet) use ($data) {
            $sheet->fromArray($data);
        });

        })->download('xlsx');

    }
}
