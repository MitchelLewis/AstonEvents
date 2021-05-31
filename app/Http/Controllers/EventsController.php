<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class EventsController extends Controller
{
    public function onPageLoad(Request $request, String $id) {
        return view('eventPage', Event::findOrFail($id));
    }

    public function onSubmit(Request $request, String $id) {
        $answer = $request -> interested_btn;
        $model = Event::findOrFail($id);
        if($answer == "Interested") {
            DB::table('events')
            ->where('id', $id)
            ->increment('interestRanking', 1);
        } else if($answer == "Not interested" && ($model -> interestRanking - 1 >= 0)) {
            DB::table('events')
            ->where('id', $id)
            ->increment('interestRanking', -1);
        }
        return view('eventPage', Event::findOrFail($id));
    }
}
