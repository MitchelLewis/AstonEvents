<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MyEventsController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }
        
    /**
     * Shows the page for the users organised events.
     * 
     */
    public function onPageLoad() {
        $eventsForUser = DB::table('events')
        ->select()
        ->where('eventOrganiserId', Auth::id())
        ->get();
        return view('myEvents', array('events' => $eventsForUser));
    }
}