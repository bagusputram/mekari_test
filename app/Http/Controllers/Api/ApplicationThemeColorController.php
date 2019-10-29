<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Excel;

use App\Models\Setting\ApplicationThemeColor;

use App\Libraries\Hashid\Hasher;

class ApplicationThemeColorController extends Controller
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
     * Show Application Theme Color data.
     *
     * @return \Illuminate\Http\Response
     */
    public function getApplicationThemeColorById($id){
        
        $application_theme_color = ApplicationThemeColor::where('id', $id)->get();

		return $application_theme_color;
    }
}
