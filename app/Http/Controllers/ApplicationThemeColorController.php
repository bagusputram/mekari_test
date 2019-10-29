<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use Carbon\Carbon;

use App\Models\Setting\ApplicationLanguage;

use App\Libraries\Hashid\Hasher;

use App\Models\Setting\ApplicationThemeColor;

class ApplicationThemeColorController extends Controller
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
        $is_trash                           = $request->get('status') == 'trash' ? true : false;

        $application_theme_colors           = ApplicationThemeColor::all();
        $application_theme_color_count      = $application_theme_colors->count();
        $trash                              = ApplicationThemeColor::onlyTrashed()->orderBy("deleted_at", "desc");

        if ( $is_trash ) {
            $application_theme_colors = $trash->get();
        }        

        return view('pages.manage-setting.application-theme-color.index', compact('application_theme_colors', 'application_theme_color_count', 'trash'));
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
            'name'   => 'required',
            'code'   => 'required',
        ]);
        
        if ( $validator->fails() ) {
            return redirect('setting/application-theme-color')->withErrors($validator)->withInput();
        }

        $application_theme_color            = new ApplicationThemeColor;

        $application_theme_color->name      = $request->name;        
        $application_theme_color->code      = $request->code;        
        
        $application_theme_color->save();

        return redirect('setting/application-theme-color')->with('success', 'create');;
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
            'name'          => 'required',    
            'code'          => 'required',    
        ]);        

        if ( $validator->fails() ) {
            return redirect('setting/application-theme-controller')->withErrors($validator)->withInput();
        }

        $application_theme_color            = ApplicationThemeColor::find($id[0]);

        $application_theme_color->name      = $request->name;        
        $application_theme_color->code      = $request->code;   
        
        $application_theme_color->save();

        return redirect('setting/application-theme-color')->with('success', 'edit');
    }

    /**
     * Delete Level
     *
     * @return void
     */
    public function delete($id) {        
        $application_theme_color = ApplicationThemeColor::find($id[0]);        
        $application_theme_color->delete();

        return redirect('setting/application-theme-color')->with('delete' ,'delete');
    }

    /**
     * Restore Level data
     *
     * @return void
     */
    public function restore($id) {
        
        ApplicationThemeColor::onlyTrashed()->where('id', $id[0])->restore();

        return redirect('setting/application-theme-color')->with('restore', 'restore');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ApplicationThemeColor::onlyTrashed()->where('id', $id[0])->forceDelete();

        return redirect('setting/application-theme-color')->with('delete', 'delete');
    }
}
