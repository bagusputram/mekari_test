<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Excel;

use App\Models\Setting\RouteType;

use App\Libraries\Hashid\Hasher;

class RouteTypeController extends Controller
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
     * Show Route Type data.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRouteTypeById($id){
        
        $route_type = RouteType::where('id', $id)->get();

		return $route_type;
    }
}
