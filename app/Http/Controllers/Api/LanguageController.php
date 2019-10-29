<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Excel;

use App\Models\Setting\Language;

use App\Libraries\Hashid\Hasher;

class LanguageController extends Controller
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
     * Show language data.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLanguageById($id){
        
        $languages = Language::where('id', $id)->get();

		return $languages;
    }
}
