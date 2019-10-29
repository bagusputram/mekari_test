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

class DistrictController extends Controller
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

        $districts          = District::all();
        $district_count     = $districts->count();
        $trash              = District::onlyTrashed()->orderBy("deleted_at", "desc");
        //$cities             = City::all();
        $provinces          = Province::all();

        if ( $is_trash ) {
            $districts = $trash->get();
        }

        return view('pages.manage-setting.district.index', compact('provinces', 'district_count', 'trash','is_trash'));
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
            'city_id'                       => 'required',
        ]);

        if ( $validator->fails() ) {
            return redirect('setting/disctrict')->withErrors($validator)->withInput();
        }

        $district                   = new District;

        $district->province_id      = $request->province_id;
        $district->city_id          = $request->city_id;
        $district->name             = $request->name;

        $district->save();

        return redirect('setting/district')->with('success', 'create');;
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
            'city_id'                       => 'required',
        ]);

        if ( $validator->fails() ) {
            return redirect('setting/district/' . $id . '/edit')->withErrors($validator)->withInput();
        }

        $district                   = District::find($id[0]);

        $district->province_id      = $request->province_id;
        $district->city_id          = $request->city_id;
        $district->name             = $request->name;

        $district->save();

        return redirect('setting/district')->with('success', 'edit');
    }

    /**
     * Delete Menu Type
     *
     * @return void
     */
    public function delete($id)
    {
        $district = District::find($id[0]);
        $district->delete();

        return redirect('setting/district')->with('delete' ,'delete');
    }

    /**
     * Restore Menu Type data
     *
     * @return void
     */
    public function restore($id)
    {
        District::onlyTrashed()->where('id', $id[0])->restore();
        Subdistrict::onlyTrashed()->where('district_id', $id[0])->restore();

        return redirect('setting/district')->with('restore', 'restore');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        District::onlyTrashed()->where('id', $id[0])->forceDelete();

        return redirect('setting/district')->with('delete', 'delete');
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
