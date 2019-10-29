<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Excel;

use App\Models\Setting\MenuType;

use App\Libraries\Hashid\Hasher;

class MenuTypeController extends Controller
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
     * Show Menu Type data.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMenuTypeById($id){
        
        $menu_type = MenuType::where('id', $id)->get();

		return $menu_type;
    }
}
