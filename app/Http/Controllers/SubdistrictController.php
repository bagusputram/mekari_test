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

class SubdistrictController extends Controller
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

        // $subdistricts       = Subdistrict::all();
        // $subdistrict_count  = Subdistrict::all()->count();
        $trash              = Subdistrict::onlyTrashed()->orderBy("deleted_at", "desc");
        $provinces          = Province::all();

        // dd('mausk');

        if ( $is_trash ) {
            $subdistricts = $trash->get();
        }

        return view('pages.manage-setting.subdistrict.index', compact('provinces', 'trash','is_trash'));
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
            'district_id'                   => 'required',
            'postcode'                      => 'required',
        ]);

        if ( $validator->fails() ) {
            return redirect('setting/subdisctrict')->withErrors($validator)->withInput();
        }

        $subdistrict                = new Subdistrict;

        $subdistrict->province_id   = $request->province_id;
        $subdistrict->city_id       = $request->city_id;
        $subdistrict->district_id   = $request->district_id;
        $subdistrict->name          = $request->name;
        $subdistrict->postcode      = $request->postcode;

        $subdistrict->save();

        return redirect('setting/subdistrict')->with('success', 'create');;
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
            'district_id'                   => 'required',
            'postcode'                      => 'required',
        ]);

        if ( $validator->fails() ) {
            return redirect('setting/subdistrict/' . $id . '/edit')->withErrors($validator)->withInput();
        }

        $subdistrict                = Subistrict::find($id[0]);

        $subdistrict->province_id   = $request->province_id;
        $subdistrict->city_id       = $request->city_id;
        $subdistrict->district_id   = $request->district_id;
        $subdistrict->name          = $request->name;
        $subdistrict->postcode      = $request->postcode;

        $subdistrict->save();

        return redirect('setting/subdistrict')->with('success', 'edit');
    }

    /**
     * Delete Menu Type
     *
     * @return void
     */
    public function delete($id)
    {
        $subdistrict = Subdistrict::find($id[0]);
        $subdistrict->delete();

        return redirect('setting/subdistrict')->with('delete' ,'delete');
    }

    /**
     * Restore Menu Type data
     *
     * @return void
     */
    public function restore($id)
    {
        Subdistrict::onlyTrashed()->where('id', $id[0])->restore();

        return redirect('setting/subdistrict')->with('restore', 'restore');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Subdistrict::onlyTrashed()->where('id', $id[0])->forceDelete();

        return redirect('setting/subdistrict')->with('delete', 'delete');
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
