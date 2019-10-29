<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Excel;

use App\Models\Setting\CompanyType;

use App\Libraries\Hashid\Hasher;

class CompanyTypeController extends Controller
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

        $company_types          = CompanyType::all();
        $company_type_count     = $company_types->count();
        $trash                  = CompanyType::onlyTrashed()->orderBy("deleted_at", "desc");        

        if ( $is_trash ) {
            $company_types = $trash->get();
        }        

        return view('pages.manage-setting.company-type.index', compact('company_types', 'company_type_count', 'trash'));
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
            'name'      => 'required',
            'label'     => 'required',
        ]);
        
        if ( $validator->fails() ) {
            return redirect('setting/company-type')->withErrors($validator)->withInput();
        }

        $company_type                   = new CompanyType;

        $company_type->name             = $request->name;
        $company_type->label        = $request->label;        
        
        $company_type->save();

        return redirect('setting/company-type')->with('success', 'create');;
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
            'label'     => 'required',
        ]);        

        if ( $validator->fails() ) {
            return redirect('setting/company-type/' . $id . '/edit')->withErrors($validator)->withInput();
        }

        $company_type               = CompanyType::find($id[0]);        

        $company_type->label        = $request->label;        
        $company_type->name         = $request->name;        
        
        $company_type->save();

        return redirect('setting/company-type')->with('success', 'edit');
    }

    /**
     * Delete Level
     *
     * @return void
     */
    public function delete($id) {        
        $company_type = CompanyType::find($id[0]);        
        $company_type->delete();

        return redirect('setting/company-type')->with('delete' ,'delete');
    }

    /**
     * Restore Level data
     *
     * @return void
     */
    public function restore($id) {
        
        CompanyType::onlyTrashed()->where('id', $id[0])->restore();

        return redirect('setting/company-type')->with('restore', 'restore');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CompanyType::onlyTrashed()->where('id', $id[0])->forceDelete();

        return redirect('setting/company-type')->with('delete', 'delete');
    }    
}
