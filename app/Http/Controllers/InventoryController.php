<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Models\Setting\Inventory;
use App\Models\Setting\Office;

use App\Libraries\Hashid\Hasher;

class InventoryController extends Controller
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

        $inventorys             = Inventory::all();
        $offices                = Office::all();
        $inventory_count        = $inventorys->count();
        $trash                  = Inventory::onlyTrashed()->orderBy("deleted_at", "desc");
        
        if ( $is_trash ) {
            $inventorys = $trash->get();
        }        

        return view('pages.inventory.index', compact('inventorys', 'inventory_count', 'trash','is_trash','offices'));
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
            'name'                      => 'required',
            'price'                     => 'required',
            'stock_in'                  => 'required',
            'stock_out'                 => 'required',
            'office_id'                 => 'required',
            'inventory_image'           => 'required',
        ]);
        
        if ( $validator->fails() ) {
            return redirect('inventory')->withErrors($validator)->withInput();
        }

        $inventory_image    = $request->file('inventory_image');        
        $extension          = $inventory_image->getClientOriginalExtension();
        Storage::disk('public')->put($inventory_image->getFilename().'.'.$extension,  File::get($inventory_image));

        $inventory                      = new Inventory;

        $inventory->name                = $request->name;
        $inventory->office_id           = $request->office_id;
        $inventory->price               = $request->price;
        $inventory->stock_in            = $request->stock_in;
        $inventory->stock_out           = $request->stock_out;
        $inventory->mime                = $inventory_image->getClientMimeType();
        $inventory->original_filename   = $inventory_image->getClientOriginalName();
        $inventory->filename            = $inventory_image->getFilename().'.'.$extension;
        
        $inventory->save();

        return redirect('inventory')->with('success', 'create');;
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
            'name'                      => 'required',
            'price'                     => 'required',
            'stock_in'                  => 'required',
            'stock_out'                 => 'required',
            'office_id'                 => 'required',            
        ]);
        
        if ( $validator->fails() ) {
            return redirect('inventory')->withErrors($validator)->withInput();
        }        

        $inventory_image                = $request->file('inventory_image');

        $inventory                      = Inventory::find($id[0]);

        $inventory->name                = $request->name;
        $inventory->office_id           = $request->office_id;
        $inventory->price               = $request->price;
        $inventory->stock_in            = $request->stock_in;
        $inventory->stock_out           = $request->stock_out;
        if($inventory_image != NULL){
            $extension          = $inventory_image->getClientOriginalExtension();
            Storage::disk('public')->put($inventory_image->getFilename().'.'.$extension,  File::get($inventory_image));
            $inventory->mime                = $inventory_image->getClientMimeType();
            $inventory->original_filename   = $inventory_image->getClientOriginalName();
            $inventory->filename            = $inventory_image->getFilename().'.'.$extension;        
        }        
        $inventory->save();

        return redirect('inventory')->with('success', 'edit');
    }

    /**
     * Delete Level
     *
     * @return void
     */
    public function delete($id) {        
        $inventory = Inventory::find($id[0]);        
        $inventory->delete();

        return redirect('inventory')->with('delete' ,'delete');
    }

    /**
     * Restore Level data
     *
     * @return void
     */
    public function restore($id) {
        
        Inventory::onlyTrashed()->where('id', $id[0])->restore();

        return redirect('inventory')->with('restore', 'restore');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Inventory::onlyTrashed()->where('id', $id[0])->forceDelete();

        return redirect('inventory')->with('delete', 'delete');
    }    
}
