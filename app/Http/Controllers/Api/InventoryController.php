<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Excel;

use Yajra\DataTables\Facades\DataTables;

use App\Models\Setting\Inventory;

use App\Libraries\Hashid\Hasher;

class InventoryController extends Controller
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
    public function getInventoryById($id){
        
        $inventory = Inventory::where('id', $id)->get();

		return $inventory;
    }

    public function getInventoryData($trash){
        if( $trash == 0 ){
            $inventory = Inventory::join('offices','offices.id','=','inventories.office_id')
            ->select([
                'inventories.id as id',
                'inventories.name as name',
                'inventories.price as price',
                'inventories.stock_in as stock_in',
                'inventories.stock_out as stock_out',
                'offices.name as office',
                'inventories.filename as filename'
            ])
            ->orderBy('id','asc');

            return Datatables::of($inventory)->addColumn('action', function ($inventory) {
                return '
                    <button type="button" class="btn btn-primary btn-sm btn-edit" id="btn-edit" edit_id='.$inventory->hashid.'><i class="fa fa-pencil" style="pointer-events:none;"></i></button>
                    <button type="button" class="btn btn-danger btn-sm btn-delete" id="btn-delete" delete_id='.$inventory->hashid.'><i class="fa fa-trash" style="pointer-events:none;"></i></button>
                ';
            })->addColumn('image', function ($inventory) {
                return '
                    <img width="100%" src="'.url("uploads/".$inventory->filename).'">
                ';
            })->rawColumns(['image', 'action'])->make(true);
        } else {
            $inventory = Inventory::onlyTrashed()
            ->join('offices','offices.id','=','inventories.office_id')             
            ->select([
                'inventories.id as id',
                'inventories.name as name',
                'inventories.price as price',
                'inventories.stock_in as stock_in',
                'inventories.stock_out as stock_out',
                'inventories.filename as filename',
                'offices.name as office'
            ])
            ->orderBy('id','asc');

            return Datatables::of($inventory)->addColumn('action', function ($inventory) {
                return '
                    <button type="submit" class="btn btn-success btn-sm btn-restore" restore_id='.$inventory->hashid.'><i class="fa fa-undo" style="pointer-events:none;"></i></button>
                    <button type="button" class="btn btn-danger btn-sm btn-destroy" destroy_id='.$inventory->hashid.'><i class="fa fa-trash" style="pointer-events:none;"></i></button>
                ';
            })->addColumn('image', function ($inventory) {
                return '
                    <img width="100%" src="'.url("uploads/".$inventory->filename).'">
                ';
            })->rawColumns(['image', 'action'])->make(true);
        }
    }    
}
