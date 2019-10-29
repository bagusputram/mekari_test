<?php

namespace App\Http\Controllers;

use Auth;
use Route;
use Validator;

use App\Models\Event;
use Illuminate\Http\Request;

use App\Libraries\Hashid\Hasher;

class EventController extends Controller
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
        // checker for button to show in index
        $currentRouteName       = Route::currentRouteName();
        $user_role_id           = Auth::user()->user_role_id;
        $user_menu_permissions  = GetUserButtonPermission($user_role_id,$currentRouteName);

        foreach($user_menu_permissions as $user_menu_permission){
            $allowed_button[]   = $user_menu_permission->menuTypeName->name;
        }

        // checker if view trash index
        $is_trash               = $request->get('status') == 'trash' ? true : false;

        //fetch event data
        $events                 = Event::all();
        // fetch sum of event
        $event_count             = $events->count();
        // fetch sum of trash
        $trash                  = Event::onlyTrashed()->orderBy("deleted_at", "desc");

        // if user view trash index fetch all trash data
        if ( $is_trash ) {
            $bands = $trash->get();
        }

        // return view data
        return view('pages.event.index', compact('events', 'event_count', 'trash', 'allowed_button', 'is_trash'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('pages.event.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }
}
