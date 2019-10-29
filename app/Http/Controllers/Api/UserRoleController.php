<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Excel;

use App\Models\Setting\UserRole;

use App\Libraries\Hashid\Hasher;

class UserRoleController extends Controller
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
    public function getUserRoleById($id){
        
        $user_role = UserRole::where('id', $id)->get();

		return $user_role;
    }
}
