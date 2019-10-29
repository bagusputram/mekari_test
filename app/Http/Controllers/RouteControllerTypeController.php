<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Excel;

use App\Models\Setting\RouteControllerType;

use App\Libraries\Hashid\Hasher;

class RouteControllerTypeController extends Controller
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
        $is_trash                       = $request->get('status') == 'trash' ? true : false;

        $route_controller_types         = RouteControllerType::all();
        $route_controller_type_count    = $route_controller_types->count();
        $trash                          = RouteControllerType::onlyTrashed()->orderBy("deleted_at", "desc");        

        if ( $is_trash ) {
            $route_controller_types = $trash->get();
        }        

        return view('pages.manage-setting.route-controller-type.index', compact('route_controller_types', 'route_controller_type_count', 'trash'));
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
            return redirect('setting/route-controller-type')->withErrors($validator)->withInput();
        }

        $route_controller_type          = new RouteControllerType;
        
        $route_controller_type->name    = $request->name;        
        
        $route_controller_type->save();

        return redirect('setting/route-controller-type')->with('success', 'create');;
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
            return redirect('setting/route-controller-type/' . $id . '/edit')->withErrors($validator)->withInput();
        }

        $route_controller_type         = RouteControllerType::find($id[0]);        

        $route_controller_type->name   = $request->name;
        
        $route_controller_type->save();

        return redirect('setting/route-controller-type')->with('success', 'edit');
    }

    /**
     * Delete Route Controller Type
     *
     * @return void
     */
    public function delete($id) 
    {        
        $route_controller_type = RouteControllerType::find($id[0]);        
        $route_controller_type->delete();

        return redirect('setting/route-controller-type')->with('delete' ,'delete');
    }

    /**
     * Restore Route Controller Type data
     *
     * @return void
     */
    public function restore($id) 
    {
        
        RouteControllerType::onlyTrashed()->where('id', $id[0])->restore();

        return redirect('setting/route-controller-type')->with('restore', 'restore');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        RouteControllerType::onlyTrashed()->where('id', $id[0])->forceDelete();

        return redirect('setting/route-controller-type')->with('delete', 'delete');
    }

    public function import(Request $request) {

        if ($request->hasFile('file_import')) {
            $path = $request->file('file_import')->getRealPath();
            $data = Excel::load($path, function ($render){})->get();

            if (!empty($data) && $data->count()) {
                $insert = array();

                foreach ( $data as $key => $value ) {

                    $insert['name']           = $value->name ?? null;

                    RouteControllerType::create($insert);          
                }
            }
        }

        return redirect('setting/route-controller-type')->with('success', 'create');

    }

    public function export(){
        $data[] = [      
            'name' => null,
        ];

        Excel::create('ris-route-controller-type-import', function($excel) use ($data) {
        $excel->sheet('Route Controller Type', function($sheet) use ($data) {
            $sheet->fromArray($data);
        });

        })->download('xlsx');

    }
}
