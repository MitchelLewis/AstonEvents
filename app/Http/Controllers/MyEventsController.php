<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MyEventsController extends Controller {
    public function __construct(){
        $this->middleware('auth');
    }
        
    public function onPageLoad(Request $request) {
        $eventsForUser = DB::table('events')
        ->select()
        ->where('eventOrganiserId', Auth::id())
        ->get();
        return view('myEvents', array('events' => $eventsForUser));
    }
}