<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function onPageLoad(Request $request) {
        return view('index', array('events' => Event::all()));
    }

    public function onPageSubmit(Request $request) {
        $rank = htmlspecialchars($request->input('rank'));
        $category = htmlspecialchars($request->input('category'));
        if($rank == "1") {
            $order = "desc";
        } else {
            $order = "asc";
        }
    
        if($rank != "" && $category != "") {
            $events = DB::table('events')
            ->where('eventCategory', '=', $category)
            ->orderBy('interestRanking', $order)
            ->limit(25)
            ->get();
        } else if ($rank != "" && $category == "") {
            $events = DB::table('events')
            ->orderBy('interestRanking', $order)
            ->limit(25)
            ->get();
        } else if ($rank == "" && $category != "") {
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
