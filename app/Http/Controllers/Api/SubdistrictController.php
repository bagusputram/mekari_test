<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Excel;
use DB;

use Yajra\DataTables\Facades\DataTables;

use App\Models\Setting\Subdistrict;

use App\Libraries\Hashid\Hasher;

class SubdistrictController extends Controller
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
    public function getSubdistrictById($id){

        $subdistrict = Subdistrict::where('id', $id)->get();

		return $subdistrict;
    }

    public function getSubdistrictData($trash){
        if( $trash == 0 ){
            $subdistrict = Subdistrict::join('provinces','provinces.id','=','subdistricts.province_id')->join('cities','cities.id','=','subdistricts.city_id')->join('districts','districts.id','=','subdistricts.district_id')->select(['subdistricts.id as id','subdistricts.name as name','subdistricts.postcode as postcode','provinces.name as provincename','districts.name as districtname','cities.name as cityname'])->orderBy('id','asc');

            return Datatables::of($subdistrict)->addColumn('action', function ($subdistrict) {
                return '
                    <button type="button" class="btn btn-primary btn-sm btn-edit" id="btn-edit" edit_id='.$subdistrict->hashid.'><i class="fa fa-pencil" style="pointer-events:none;"></i></button>
                    <button type="button" class="btn btn-danger btn-sm btn-delete" id="btn-delete" delete_id='.$subdistrict->hashid.'><i class="fa fa-trash" style="pointer-events:none;"></i></button>
                ';
            })->make(true);
        } else {
            $subdistrict = Subdistrict::onlyTrashed()->join('provinces','provinces.id','=','subdistricts.province_id')->join('cities','cities.id','=','subdistricts.city_id')->join('districts','districts.id','=','subdistricts.district_id')->select(['subdistricts.id as id','subdistricts.name as name','subdistricts.postcode as postcode','provinces.name as provincename','districts.name as districtname','cities.name as cityname']);

            return Datatables::of($subdistrict)->addColumn('action', function ($subdistrict) {
                return '
                    <button type="submit" class="btn btn-success btn-sm btn-restore" restore_id='.$subdistrict->hashid.'><i class="fa fa-undo" style="pointer-events:none;"></i></button>
                    <button type="button" class="btn btn-danger btn-sm btn-destroy" destroy_id='.$subdistrict->hashid.'><i class="fa fa-trash" style="pointer-events:none;"></i></button>
                ';
            })->make(true);
        }
    }

    public function getSubdistrictDataByCity($city_id){

        $subdistricts   = District::where('city_id',$city_id)->get();

		return $subdistricts;
    }

    public function getSubdistrictDataByDistrict($id){

        $subdistricts   = Subdistrict::where('district_id',$id)->get();

		return $subdistricts;
    }
}
