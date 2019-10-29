<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Excel;

use Yajra\DataTables\Facades\DataTables;

use App\Models\Setting\District;

use App\Libraries\Hashid\Hasher;

class DistrictController extends Controller
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
    public function getDistrictById($id){

        $district = District::where('id', $id)->get();

		return $district;
    }

    public function getDistrictData($trash){
        if( $trash == 0 ){
            $district = District::join('provinces','provinces.id','=','districts.province_id')
            ->join('cities','cities.id','=','districts.city_id')
            ->select([
                'districts.id as id',
                'districts.name as name',
                'provinces.name as provincename',
                'cities.name as cityname'
            ])
            ->orderBy('id','asc');

            return Datatables::of($district)->addColumn('action', function ($district) {
                return '
                    <button type="button" class="btn btn-primary btn-sm btn-edit" id="btn-edit" edit_id='.$district->hashid.'><i class="fa fa-pencil" style="pointer-events:none;"></i></button>
                    <button type="button" class="btn btn-danger btn-sm btn-delete" id="btn-delete" delete_id='.$district->hashid.'><i class="fa fa-trash" style="pointer-events:none;"></i></button>
                ';
            })->make(true);
        } else {
            $district = District::onlyTrashed()
            ->join('provinces','provinces.id','=','districts.province_id')
            ->join('cities','cities.id','=','districts.city_id')
            ->select([
                'districts.id as id',
                'districts.name as name',
                'provinces.name as provincename',
                'cities.name as cityname'
            ])
            ->orderBy('id','asc');

            return Datatables::of($district)->addColumn('action', function ($district) {
                return '
                    <button type="submit" class="btn btn-success btn-sm btn-restore" restore_id='.$district->hashid.'><i class="fa fa-undo" style="pointer-events:none;"></i></button>
                    <button type="button" class="btn btn-danger btn-sm btn-destroy" destroy_id='.$district->hashid.'><i class="fa fa-trash" style="pointer-events:none;"></i></button>
                ';
            })->make(true);
        }
    }

    public function getDistrictDataByCity($id){

        $districts   = District::where('city_id',$id)->get();

		return $districts;
    }
}
