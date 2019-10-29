<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Excel;

use App\Models\Setting\Gender;

use App\Libraries\Hashid\Hasher;

class GenderController extends Controller
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

        $genders        = Gender::all();
        $gender_count   = $genders->count();
        $trash          = Gender::onlyTrashed()->orderBy("deleted_at", "desc");
        $create         = true;
        $edit           = false;

        if ( $is_trash ) {
            $genders = $trash->get();
        }        

        return view('pages.manage-setting.gender.index', compact('genders', 'gender_count', 'trash','create','edit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.manage-setting.gender.create');
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
            'gender_name'       => 'required',
            'gender_language'   => 'required',
        ]);
        
        if ( $validator->fails() ) {
            return redirect('setting/gender')->withErrors($validator)->withInput();
        }

        $gender = new Gender;

        $gender->gender_name            = $request->gender_name;
        $gender->gender_language        = $request->gender_language;
        
        $gender->save();

        return redirect('setting/gender')->with('success', 'create');;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {        
        $genders        = Gender::all();
        $gender_count   = $genders->count();
        $trash          = Gender::onlyTrashed()->orderBy("deleted_at", "desc");
        
        $gender         = Gender::find($id[0]);
        $edit           = true;
        $create         = false;
        
        return view('pages.manage-setting.gender.index', compact('gender','edit','create','genders','gender_count','trash'));
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
            'gender_name'       => 'required',
            'gender_language'   => 'required',
        ]);        

        if ( $validator->fails() ) {
            return redirect('setting/gender/' . $id . '/edit')->withErrors($validator)->withInput();
        }

        $gender                     = Gender::find($id[0]);        

        $gender->gender_name        = $request->gender_name;
        $gender->gender_language    = $request->gender_language;
        
        $gender->save();

        return redirect('setting/gender')->with('success', 'edit');
    }

    /**
     * Delete Level
     *
     * @return void
     */
    public function delete($id) {        
        $gender = Gender::find($id[0]);        
        $gender->delete();

        return redirect('setting/gender')->with('delete' ,'delete');
    }

    /**
     * Restore Level data
     *
     * @return void
     */
    public function restore($id) {
        
        Gender::onlyTrashed()->where('id', $id[0])->restore();

        return redirect('setting/gender')->with('restore', 'restore');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gender::onlyTrashed()->where('id', $id[0])->forceDelete();

        return redirect('setting/gender')->with('delete', 'delete');
    }

    public function import(Request $request) {

        if ($request->hasFile('file_import')) {
            $path = $request->file('file_import')->getRealPath();
            $data = Excel::load($path, function ($render){})->get();

            if (!empty($data) && $data->count()) {
                $insert = array();

                foreach ( $data as $key => $value ) {

                    $insert['gender_name']           = $value->gender_name ?? null;

                    Gender::create($insert);          
                }
            }
        }

        return redirect('setting/gender')->with('success', 'create');

    }

    public function export(){
        $data[] = [      
            'gender_name' => null,
        ];

        Excel::create('ris-gender-import', function($excel) use ($data) {
        $excel->sheet('Gender', function($sheet) use ($data) {
            $sheet->fromArray($data);
        });

        })->download('xlsx');

    }
}
