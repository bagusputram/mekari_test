<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Setting\ApplicationLanguage;
use App\Models\Setting\Language;
use App\Models\Setting\SessionTimeout;

class MasterDataSettingController extends Controller
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
        $session_timeout        = SessionTimeout::find(1);
        $application_language   = ApplicationLanguage::find(1);
        $languages              = Language::all();
        
        return view('pages.manage-setting.master-data.index',compact('session_timeout','application_language','languages'));
    }
}
