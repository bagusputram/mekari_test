<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Setting\RouteList;

use App\Libraries\Hashid\Hasher;
use App\ToDoList;
use Auth;
use Route;
use Validator;

class ToDoListController extends Controller
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
        //get if filter by trash data
        $data['is_trash'] = $request->get('status') == 'trash' ? true : false;

        // count data not deleted
        $data['count_data'] = ToDoList::all()->count();
        // count data deleted
        $data['count_trash'] = ToDoList::onlyTrashed()->orderBy("deleted_at", "desc")->count();
        // get current route data
        $data['current_route'] = RouteList::where('route_menu_name', Route::currentRouteName())->first();        

        return view('pages.task.index', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate input
        $validator = Validator::make($request->all(), [
            'task' => 'required',            
        ]);

        // redirect to input data if not valid
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // initialize new data
        $task = new ToDoList;

        // initialize data to store
        $task->task = $request->task;        
        $task->task_created_by = Auth::user()->id;

        // save data
        $task->save();

        // redirect to index
        return redirect()->back()->with('success', 'create');;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ToDoList  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validate input
        $validator = Validator::make($request->all(), [
            'task' => 'required',            
        ]);

        // redirect to input data if not valid
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // initialize data
        $task = ToDoListH::find($id[0]);

        // initialize data to store
        $task->task = $request->task;        
        $task->task_modified_by = Auth::user()->id;

        // save data
        $task->save();

        // redirect to index
        return redirect()->back()->with('success', 'edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ToDoList  $task
     * @return \Illuminate\Http\Response
     */
    public function delete($id) {
        // fetch eselon by id
        $task = ToDoList::find($id[0]);

        // delete data
        $task->delete();

        // return page to last accessed
        return redirect()->back()->with('delete' ,'delete');
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\ToDoList  $task
     * @return \Illuminate\Http\Response
     */
    public function restore($id) {
        // restore eselon that been deleted
        ToDoList::onlyTrashed()->where('id', $id[0])->restore();

        // store data edited by
        $task = ToDoList::find($id[0]);
        $task->task_modified_by = Auth::user()->id;

        $task->save();

        // return page to last accessed
        return redirect()->back()->with('restore', 'restore');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ToDoList  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //delete data from database
        ToDoList::onlyTrashed()->where('id', $id[0])->forceDelete();

        // redirect data to store
        return redirect()->back()->with('delete', 'delete');
    }
}
