<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Setting\ApplicationLanguage;
use App\Models\Setting\Language;
use App\Models\Setting\SessionTimeout;

class CompanyInformationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware(['auth','user.permission']);
    }
    
    public function index(Request $request)
    {               
        return view('pages.company-information.index');
    }
}
