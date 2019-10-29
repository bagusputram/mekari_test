<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Excel;

use App\Models\Setting\CompanyType;

use App\Libraries\Hashid\Hasher;

class CompanyTypeController extends Controller
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
    public function getCompanyTypeById($id){
        
        $company_type = CompanyType::where('id', $id)->get();

		return $company_type;
    }
}
