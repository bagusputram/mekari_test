<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Excel;

use App\Models\Setting\Language;

use App\Libraries\Hashid\Hasher;

class LanguageController extends Controller
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

        $languages      = Language::all();
        $language_count = $languages->count();
        $trash          = Language::onlyTrashed()->orderBy("deleted_at", "desc");

        if ( $is_trash ) {
            $languages = $trash->get();
        }        

        return view('pages.manage-setting.language.index', compact('languages', 'language_count', 'trash'));
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
            'language_name'     => 'required',
            'language_id'       => 'required',
        ]);
        
        if ( $validator->fails() ) {
            return redirect('setting/language')->withErrors($validator)->withInput();
        }

        $language                       = new Language;

        $language->language_name        = $request->language_name;
        $language->language_id          = $request->language_id;
        
        $language->save();

        return redirect('setting/language')->with('success', 'create');;
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
            'language_name'     => 'required',
            'language_id'       => 'required',
        ]);        

        if ( $validator->fails() ) {
            return redirect('setting/language/' . $id . '/edit')->withErrors($validator)->withInput();
        }

        $language                   = Language::find($id[0]);        

        $language->language_name    = $request->language_name;
        $language->language_id      = $request->language_id;
        
        $language->save();

        return redirect('setting/language')->with('success', 'edit');
    }

    /**
     * Delete Level
     *
     * @return void
     */
    public function delete($id) {        
        $language = Language::find($id[0]);        
        $language->delete();

        return redirect('setting/language')->with('delete' ,'delete');
    }

    /**
     * Restore Level data
     *
     * @return void
     */
    public function restore($id) {
        
        Language::onlyTrashed()->where('id', $id[0])->restore();

        return redirect('setting/language')->with('restore', 'restore');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Language::onlyTrashed()->where('id', $id[0])->forceDelete();

        return redirect('setting/language')->with('delete', 'delete');
    }

    public function import(Request $request) {

        if ($request->hasFile('file_import')) {
            $path = $request->file('file_import')->getRealPath();
            $data = Excel::load($path, function ($render){})->get();

            if (!empty($data) && $data->count()) {
                $insert = array();

                foreach ( $data as $key => $value ) {

                    $insert['language_name']    = $value->language_name ?? null;
                    $insert['language_id']      = $value->language_id ?? null;

                    Language::create($insert);          
                }
            }
        }

        return redirect('setting/language')->with('success', 'create');

    }

    public function export(){
        $data[] = [      
            'language_name' => null,
            'language_id' => null,
        ];

        Excel::create('ris-language-import', function($excel) use ($data) {
        $excel->sheet('Language', function($sheet) use ($data) {
            $sheet->fromArray($data);
        });

        })->download('xlsx');

    }
}
