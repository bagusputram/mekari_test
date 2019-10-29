<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Excel;

use App\Models\Setting\City;
use App\Models\Setting\District;
use App\Models\Setting\Province;

use App\Imports\ProvinceImport;
use App\Exports\Template\ProvinceExportTemplate;

use App\Libraries\Hashid\Hasher;
use App\Models\Setting\Subdistrict;

class ProvinceController extends Controller
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

        $provinces          = Province::all();
        $province_count     = $provinces->count();
        $trash              = Province::onlyTrashed()->orderBy("deleted_at", "desc");

        if ( $is_trash ) {
            $provinces = $trash->get();
        }

        return view('pages.manage-setting.province.index', compact('provinces', 'province_count', 'trash'));
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
        ]);

        if ( $validator->fails() ) {
            return redirect('setting/province')->withErrors($validator)->withInput();
        }

        $province               = new Province;

        $province->name         = $request->name;

        $province->save();

        return redirect('setting/province')->with('success', 'create');;
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
        ]);

        if ( $validator->fails() ) {
            return redirect('setting/province/' . $id . '/edit')->withErrors($validator)->withInput();
        }

        $province           = Province::find($id[0]);

        $province->name     = $request->name;

        $province->save();

        return redirect('setting/province')->with('success', 'edit');
    }

    /**
     * Delete Menu Type
     *
     * @return void
     */
    public function delete($id)
    {
        $province = Province::find($id[0]);
        $province->delete();

        return redirect('setting/province')->with('delete' ,'delete');
    }

    /**
     * Restore Menu Type data
     *
     * @return void
     */
    public function restore($id)
    {

        Province::onlyTrashed()->where('id', $id[0])->restore();
        City::onlyTrashed()->where('province_id',$id[0])->restore();
        District::onlyTrashed()->where('province_id',$id[0])->restore();
        Subdistrict::onlyTrashed()->where('province_id',$id[0])->restore();

        return redirect('setting/province')->with('restore', 'restore');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Province::onlyTrashed()->where('id', $id[0])->forceDelete();

        return redirect('setting/province')->with('delete', 'delete');
    }

    public function import(Request $request) {

        //dd($request->file('file_import')->getRealPath());

        if ($request->hasFile('file_import')) {

            $path = $request->file('file_import');

            Excel::import(new ProvinceImport, $path);

            return redirect('setting/province')->with('success', 'create');

        }
        else {
            return redirect('setting/province')->with('failed', 'failed');
        }

    }

    public function export()
    {
        return Excel::download(new ProvinceExportTemplate, 'ris-province-import.xlsx');
    }
}
