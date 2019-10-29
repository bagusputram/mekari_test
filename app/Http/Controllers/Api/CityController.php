<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Excel;

use App\Models\Setting\City;

use App\Libraries\Hashid\Hasher;

class CityController extends Controller
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
    public function getCityById($id){

        $city = City::where('id', $id)->get();

		return $city;
    }

    public function getCityDataByProvince($province_id){

        $cities   = City::where('province_id',$province_id)->get();

		return $cities;
    }
}
