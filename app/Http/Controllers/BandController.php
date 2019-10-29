<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Route;
use Validator;

use App\Models\Band;

use App\Libraries\Hashid\Hasher;

class BandController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $currentRouteName       = Route::currentRouteName();
        $user_role_id           = Auth::user()->user_role_id;

        $is_trash               = $request->get('status') == 'trash' ? true : false;

        $bands                  = Band::all();
        $band_count             = $bands->count();
        $trash                  = Band::onlyTrashed()->orderBy("deleted_at", "desc");

        $user_menu_permissions  = GetUserButtonPermission($user_role_id,$currentRouteName);

        foreach($user_menu_permissions as $user_menu_permission){
            $allowed_button[]   = $user_menu_permission->menuTypeName->name;
        }

        if ( $is_trash ) {
            $bands = $trash->get();
        }

        return view('pages.band.index', compact('bands', 'band_count', 'trash','allowed_button', 'is_trash'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.band.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validator checker
        $validator = Validator::make($request->all(), [
            'band_name'         => 'required',
            'band_video_url'    => 'required',
            'band_description'  => 'required',
            'band_description'  => 'required',
            'band_status'       => 'required',
        ]);

        if ( $validator->fails() ) {
            return redirect('band/create')->withErrors($validator)->withInput();
        }

        // dd($request->input('band_photo'));

        $band = new Band;

        // band description content using summernote
        $band_description = SaveContentSummernote($request->input('band_description'));

        // band featured image
        $uploaded_file_featured_image = $band->addMediaFromRequest('band_photo')->toMediaCollection('band-photo');

        // band video cover
        $uploaded_file_video_cover = $band->addMediaFromRequest('band_video_photo')->toMediaCollection('band-video-photo');

        // Initialize data to store
        $band->band_name = $request->band_name;
        $band->band_description = $band_description;
        $band->band_slug = str_slug($request->band_name);
        $band->band_facebook = $request->band_facebook;
        $band->band_twitter = $request->band_twitter;
        $band->band_instagram = $request->band_instagram;
        $band->band_youtube = $request->band_youtube;
        $band->band_video_url = $request->band_video_url;
        $band->band_status = $request->band_status;
        $band->band_video_photo = $uploaded_file_video_cover->id;
        $band->band_photo = $uploaded_file_featured_image->id;
        $band->band_created_by = Auth::user()->id;

        // save data band
        $band->save();

        return redirect('band')->with('success', 'create');;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // fetch data band by id
        $band = Band::find($id[0])->first();

        // show page edit band
        return view('pages.band.edit', compact('band'));

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
        //validate file input
        $validator = Validator::make($request->all(), [
            'band_name'         => 'required',
            'band_video_url'    => 'required',
            'band_description'  => 'required',
            'band_status'       => 'required',
        ]);

        if ( $validator->fails() ) {
            return redirect('band/' . $id[0] . '/edit')->withErrors($validator)->withInput();
        }

        $band = Band::find($id[0]);

        // band description content using summernote
        $band_description = SaveContentSummernote($request->input('band_description'));

        // band featured image
        if( $request->band_photo != NULL ){
            $uploaded_file_featured_image = $band->addMediaFromRequest('band_photo')->toMediaCollection('band-photo');
            $band->band_photo = $uploaded_file_featured_image->id;
        }

        // band video cover
        if( $request->band_video_photo != NULL ){
            $uploaded_file_video_cover = $band->addMediaFromRequest('band_video_photo')->toMediaCollection('band-video-photo');
            $band->band_video_photo = $uploaded_file_video_cover->id;
        }
        
        // Initialize data to store
        $band->band_name = $request->band_name;
        $band->band_description = $band_description;
        $band->band_slug = str_slug($request->band_name);
        $band->band_facebook = $request->band_facebook;
        $band->band_twitter = $request->band_twitter;
        $band->band_instagram = $request->band_instagram;
        $band->band_youtube = $request->band_youtube;
        $band->band_video_url = $request->band_video_url;
        $band->band_status = $request->band_status;
        $band->band_created_by = Auth::user()->id;

        // save data band
        $band->save();

        return redirect('band')->with('success', 'edit');;

    }

    /**
     * Remove the specified resource to trash
     *
     * @return void
     */
    public function delete($id) {
        $band = Band::find($id[0]);
        $band->band_modified_by = Auth::user()->id;
        $band->delete();

        return redirect('band')->with('delete' ,'delete');
    }

    /**
     * Restore the specified resource from trash
     *
     * @return void
     */
    public function restore($id) {

        Band::onlyTrashed()->where('id', $id[0])->restore();

        $band = Band::find($id[0]);
        $band->band_modified_by = Auth::user()->id;

        $band->save();

        return redirect('band')->with('restore', 'restore');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Band::onlyTrashed()->where('id', $id[0])->forceDelete();

        return redirect('band')->with('delete', 'delete');
    }
}
