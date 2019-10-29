<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Excel;

use App\Models\Setting\Company;
use App\Models\Setting\CompanyType;

use App\Libraries\Hashid\Hasher;

class CompanyController extends Controller
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

        $companies              = Company::all();
        $company_types          = CompanyType::all();
        $company_count          = $companies->count();
        $trash                  = Company::onlyTrashed()->orderBy("deleted_at", "desc");

        if ( $is_trash ) {
            $companies = $trash->get();
        }        

        return view('pages.company-information.company.index', compact('companies', 'company_count', 'trash','company_types'));
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
            'company_type_id'       => 'required',

        ]);
        
        if ( $validator->fails() ) {
            return redirect('company-information/company')->withErrors($validator)->withInput();
        }

        $main_company                               = CompanyType::where('label','main')->first();

        if($request->company_type_id == $main_company->id){
            $company_last_main                      = Company::where('company_type_id',$main_company->id)->first();
            if(!empty($company_last_main)){
                $sub_company                        = CompanyType::where('label','sub')->first();
                $company_last_main->company_type_id = $sub_company->id;
                $company_last_main->save();
            } 
        }

        $company                        = new Company;

        $company->name                  = $request->name;
        $company->company_type_id       = $request->company_type_id;
        
        $company->save();

        return redirect('company-information/company')->with('success', 'create');;
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
            'company_type_id'       => 'required',
        ]);        

        if ( $validator->fails() ) {
            return redirect('company-information/company/' . $id . '/edit')->withErrors($validator)->withInput();
        }

        $main_company                               = CompanyType::where('label','main')->first();

        if($request->company_type_id == $main_company->id){
            $company_last_main                      = Company::where('company_type_id',$main_company->id)->first();
            if(!empty($company_last_main)){
                $sub_company                        = CompanyType::where('label','sub')->first();
                $company_last_main->company_type_id = $sub_company->id;
                $company_last_main->save();
            } 
        }

        $company                        = Company::find($id[0]);        

        $company->name                  = $request->name;        
        $company->company_type_id       = $request->company_type_id;
        
        $company->save();

        return redirect('company-information/company')->with('success', 'edit');
    }

    /**
     * Delete Level
     *
     * @return void
     */
    public function delete($id) {        
        $company_type = Company::find($id[0]);        
        $company_type->delete();

        return redirect('company-information/company')->with('delete' ,'delete');
    }

    /**
     * Restore Level data
     *
     * @return void
     */
    public function restore($id) {
        
        Company::onlyTrashed()->where('id', $id[0])->restore();

        return redirect('company-information/company')->with('restore', 'restore');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Company::onlyTrashed()->where('id', $id[0])->forceDelete();

        return redirect('company-information/company')->with('delete', 'delete');
    }    
}
