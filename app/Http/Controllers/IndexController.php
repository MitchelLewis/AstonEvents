<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    /**
     * Shows the index page with all events.
     * 
     * @param String $id - ID of the event
     */
    public function onPageLoad() {
        return view('index', array('events' => Event::all()));
    }

    /**
     * Handles the POST request for filtering the events by interest and/or category.
     * Returns a the page with the filtered results.
     * 
     * @param Request $request
     */
    public function onSubmit(Request $request) {
        $rank = htmlspecialchars($request->input('rank'));
        $category = htmlspecialchars($request->input('category'));
        if($rank === "1") {
            $order = "desc";
        } else {
            $order = "asc";
        }
    
        if($rank !== "" && $category !== "") {
            $events = DB::table('events')
            ->where('eventCategory', '=', $category)
            ->orderBy('interestRanking', $order)
            ->limit(25)
            ->get();
        } else if ($rank !== "" && $category === "") {
            $events = DB::table('events')
            ->orderBy('interestRanking', $order)
            ->limit(25)
            ->get();
        } else if ($rank === "" && $category !== "") {
            $events = DB::table('events')
            ->where('eventCategory', '=', $category)
            ->limit(25)
            ->get();
        } else {
            $events = Event::all();
        }
            
        return view('index', array('events' => $events));
    }
}
