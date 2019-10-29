<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Excel;

use App\Models\Setting\City;
use App\Models\Setting\District;
use App\Models\Setting\Province;
use App\Models\Setting\Subdistrict;

// use App\Imports\CityImport;
// use App\Exports\Template\CityExportTemplate;

use App\Libraries\Hashid\Hasher;

class CityController extends Controller
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

        $cities             = City::all();
        $city_count         = $cities->count();
        $trash              = City::onlyTrashed()->orderBy("deleted_at", "desc");
        $provinces          = Province::all();

        if ( $is_trash ) {
            $cities = $trash->get();
        }        

        return view('pages.manage-setting.city.index', compact('cities','provinces', 'city_count', 'trash'));
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
            'province_id'                   => 'required',
        ]);
        
        if ( $validator->fails() ) {
            return redirect('setting/city')->withErrors($validator)->withInput();
        }

        $city               = new City;
        
        $city->province_id  = $request->province_id;
        $city->name         = $request->name;
        
        $city->save();

        return redirect('setting/city')->with('success', 'create');;
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
            'province_id'                   => 'required',            
        ]);        

        if ( $validator->fails() ) {
            return redirect('setting/city/' . $id . '/edit')->withErrors($validator)->withInput();
        }

        $city                   = Province::find($id[0]);        

        $city->province_id      = $request->province_id;
        $city->name             = $request->name;
        
        $city->save();

        return redirect('setting/city')->with('success', 'edit');
    }

    /**
     * Delete Menu Type
     *
     * @return void
     */
    public function delete($id) 
    {        
        $city = City::find($id[0]);        
        $city->delete();

        return redirect('setting/city')->with('delete' ,'delete');
    }

    /**
     * Restore Menu Type data
     *
     * @return void
     */
    public function restore($id) 
    {
        
        City::onlyTrashed()->where('id', $id[0])->restore();
        District::onlyTrashed()->where('city_id', $id[0])->restore();
        Subdistrict::onlyTrashed()->where('city_id', $id[0])->restore();

        return redirect('setting/city')->with('restore', 'restore');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        City::onlyTrashed()->where('id', $id[0])->forceDelete();

        return redirect('setting/city')->with('delete', 'delete');
    }

    // public function import(Request $request) {
        
    //     //dd($request->file('file_import')->getRealPath());

    //     if ($request->hasFile('file_import')) {

    //         $path = $request->file('file_import');

    //         Excel::import(new ProvinceImport, $path);

    //         return redirect('setting/province')->with('success', 'create');

    //     }
    //     else {
    //         return redirect('setting/province')->with('failed', 'failed');
    //     }

    // }

    // public function export()
    // {        
    //     return Excel::download(new ProvinceExportTemplate, 'ris-province-import.xlsx');
    // }
}
