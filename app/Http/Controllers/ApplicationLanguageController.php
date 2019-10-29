<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use Carbon\Carbon;

use App\Models\Setting\ApplicationLanguage;

use App\Libraries\Hashid\Hasher;

use App\User;

class ApplicationLanguageController extends Controller
{
    /**
	 * Hasher class variable
	 * @var Hasher
	 */
    private $hasher;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware(['auth','user.permission']);
        $this->hasher = new Hasher();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'application_language'   => 'required',
        ]);

        if ( $validator->fails() ) {
            return redirect('setting/restricted-setting/')->withErrors($validator)->withInput();
        }

        $application_language               = new ApplicationLanguage;

        $application_language->language     = $request->application_language;

        $application_language->save();

        return redirect('setting/restricted-setting/')->with('success', 'create');;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'application_language'       => 'required',
        ]);

        if ( $validator->fails() ) {
            return redirect('setting/restricted-setting/')->withErrors($validator)->withInput();
        }

        $application_language                = ApplicationLanguage::find($id[0]);

        $application_language->language      = $request->application_language;

        $application_language->save();

        return redirect('setting/restricted-setting/')->with('success', 'edit');
    }
}
