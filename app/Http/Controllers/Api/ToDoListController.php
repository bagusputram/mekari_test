<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Yajra\DataTables\Facades\DataTables;

use App\ToDoList;
use App\Models\Setting\RouteList;

use App\Libraries\Hashid\Hasher;

use Route;
use Auth;

class ToDoListController extends Controller
{
    /**
	 * Hasher class variable
	 * @var Hasher
	 */
    private $hasher;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function __construct() {
	    $this->middleware(['auth:api']);
		$this->hasher = new Hasher();
    }

    /**
     * Show gender data.
     *
     * @return \Illuminate\Http\Response
     */
    public function getToDoListById($id){

        $data = ToDoList::where('id', $id)->first();

		return $data;
    }

    public function getToDoListData($trash){
        if( $trash == 0 ){
            $datas= ToDoList::query();
            $datas->orderBy('id','asc');
        } else {
            $datas= ToDoList::query();
            $datas->onlyTrashed();
            $datas->orderBy('id','asc');
        }

        return Datatables::of($datas)->addColumn('action', function ($data) {
            $route =  RouteList::where('route_menu_name', Route::currentRouteName())->first();
            $user_id = Auth::user()->user_role_id;
            $trash = empty($data->deleted_at) ? 0 : 1;
            $button = getButtonLinkDatatableMasterData($route->menu_id, $user_id, $trash, $data->hashid);

            return $button;
        })->addColumn('created_at_format', function ($data) {
            return changeTimestampFormat($data->created_at);
        })->addColumn('creator', function ($data) {
            return getAuthor($data->task_created_by);
        })->addColumn('modified_at_format', function ($data) {
            return changeTimestampFormat($data->updated_at);
        })->addColumn('modifier', function ($data) {
            return getAuthor($data->task_modified_by);
        })->make(true);

    }
}
