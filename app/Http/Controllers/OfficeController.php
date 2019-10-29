<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Excel;

use App\Models\Setting\Office;
use App\Models\Setting\Province;
use App\Models\Setting\Company;

use App\Libraries\Hashid\Hasher;

class OfficeController extends Controller
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
        $is_trash               = $request->get('status') == 'trash' ? true : false;

        $offices                = Office::all();
        $provinces              = Province::all();
        $companies              = Company::all();
        $office_count           = $offices->count();
        $trash                  = Company::onlyTrashed()->orderBy("deleted_at", "desc");

        if ( $is_trash ) {
            $offices = $trash->get();
        }

        return view('pages.company-information.office.index', compact('offices', 'companies', 'trash','office_count','provinces'));
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
            'name'                  => 'required',
            'company_id'            => 'required',
            'address'               => 'required',
            'phone_number'          => 'required',
            'province_id'           => 'required',
            'city_id'               => 'required',
            'district_id'           => 'required',
            'subdistrict_id'        => 'required',
        ]);

        if ( $validator->fails() ) {
            return redirect('company-information/office')->withErrors($validator)->withInput();
        }

        $office                         = new Office;

        $office->name                   = $request->name;
        $office->company_id             = $request->company_id;
        $office->address                = $request->address;
        $office->phone_number           = $request->phone_number;
        $office->province_id            = $request->province_id;
        $office->city_id                = $request->city_id;
        $office->district_id            = $request->district_id;
        $office->subdistrict_id         = $request->subdistrict_id;

        $office->save();

        return redirect('company-information/office')->with('success', 'create');;
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
            'name'                  => 'required',
            'company_id'            => 'required',
            'address'               => 'required',
            'phone_number'          => 'required',
            'province_id'           => 'required',
            'city_id'               => 'required',
            'district_id'           => 'required',
            'subdistrict_id'        => 'required',
        ]);

        if ( $validator->fails() ) {
            return redirect('company-information/office/' . $id . '/edit')->withErrors($validator)->withInput();
        }

        $office                         = Office::find($id[0]);

        $office->name                   = $request->name;
        $office->company_id             = $request->company_id;
        $office->address                = $request->address;
        $office->phone_number           = $request->phone_number;
        $office->province_id            = $request->province_id;
        $office->city_id                = $request->city_id;
        $office->district_id            = $request->district_id;
        $office->subdistrict_id         = $request->subdistrict_id;

        $office->save();

        return redirect('company-information/office')->with('success', 'edit');
    }

    /**
     * Delete Level
     *
     * @return void
     */
    public function delete($id) {
        $office = Office::find($id[0]);
        $office->delete();

        return redirect('company-information/office')->with('delete' ,'delete');
    }

    /**
     * Restore Level data
     *
     * @return void
     */
    public function restore($id) {

        Office::onlyTrashed()->where('id', $id[0])->restore();

        return redirect('company-information/office')->with('restore', 'restore');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Office::onlyTrashed()->where('id', $id[0])->forceDelete();

        return redirect('company-information/office')->with('delete', 'delete');
    }
}
