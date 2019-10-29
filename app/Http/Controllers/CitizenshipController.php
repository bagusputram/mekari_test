<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Excel;

use App\Models\Setting\Citizenship;

use App\Libraries\Hashid\Hasher;

class CitizenshipController extends Controller
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

        $citizenships           = Citizenship::all();
        $citizenship_count      = $citizenships->count();
        $trash                  = Citizenship::onlyTrashed()->orderBy("deleted_at", "desc");
        $create                 = true;
        $edit                   = false;

        if ( $is_trash ) {
            $citizenships = $trash->get();
        }

        return view('pages.manage-setting.citizenship.index', compact('citizenships', 'citizenship_count', 'trash','create','edit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.manage-setting.citizenship.create');
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
            'citizenship_name'    => 'required',
            'citizenship_label'   => 'required',
        ]);

        if ( $validator->fails() ) {
            return redirect('setting/citizenship')->withErrors($validator)->withInput();
        }

        $citizenship                    = new Citizenship;

        $citizenship->citizenship_name  = $request->citizenship_name;
        $citizenship->citizenship_label = $request->citizenship_label;

        $citizenship->save();

        return redirect('setting/citizenship')->with('success', 'create');;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $citizenships       = Citizenship::all();
        $citizenship_count  = $citizenships->count();
        $trash              = Citizenship::onlyTrashed()->orderBy("deleted_at", "desc");

        $citizenship        = Citizenship::find($id[0]);
        $edit               = true;
        $create             = false;

        return view('pages.manage-setting.citizenship.index', compact('citizenships','citizenship_count','trash','citizenship','edit','create'));
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
            'citizenship_name'    => 'required',
            'citizenship_label'    => 'required',
        ]);

        if ( $validator->fails() ) {
            return redirect('setting/citizenship/' . $id . '/edit')->withErrors($validator)->withInput();
        }

        $citizenship                    = Citizenship::find($id[0]);

        $citizenship->citizenship_name  = $request->citizenship_name;
        $citizenship->citizenship_label = $request->citizenship_label;

        $citizenship->save();

        return redirect('setting/citizenship')->with('success', 'edit');
    }

    /**
     * Delete Level
     *
     * @return void
     */
    public function delete($id) {
        $citizenship = Citizenship::find($id[0]);
        $citizenship->delete();

        return redirect('setting/citizenship')->with('delete' ,'delete');
    }

    /**
     * Restore Level data
     *
     * @return void
     */
    public function restore($id) {

        Citizenship::onlyTrashed()->where('id', $id[0])->restore();

        return redirect('setting/citizenship')->with('restore', 'restore');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Citizenship::onlyTrashed()->where('id', $id[0])->forceDelete();

        return redirect('setting/citizenship')->with('delete', 'delete');
    }

    public function import(Request $request) {

        if ($request->hasFile('file_import')) {
            $path = $request->file('file_import')->getRealPath();
            $data = Excel::load($path, function ($render){})->get();

            if (!empty($data) && $data->count()) {
                $insert = array();

                foreach ( $data as $key => $value ) {

                    $insert['citizenship_name']     = $value->citizenship_name ?? null;
                    $insert['citizenship_label']    = $value->citizenship_label ?? null;

                    Citizenship::create($insert);
                }
            }
        }

        return redirect('setting/citizenship')->with('success', 'create');

    }

    public function export(){
        $data[] = [
            'citizenship_name'  => null,
            'citizenship_label' => null,
        ];

        Excel::create('ris-citizenship-import', function($excel) use ($data) {
        $excel->sheet('Citizenship', function($sheet) use ($data) {
            $sheet->fromArray($data);
        });

        })->download('xlsx');

    }
}
