<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class EventsController extends Controller
{
    public function onPageLoad(Request $request, String $id) {
        $event = Event::findOrFail($id);
        $relatedContentId = $event->relatedContent;
        $relatedEvent = null;
        if($relatedContentId != null && $relatedContentId != -1) {
            $relatedEvent = Event::findOrFail($relatedContentId);
        }
        $eventImg = Image::select('filename')->where('event_id', $event->id)->get();
        if($eventImg->isEmpty()) {
            $eventImg = "event_placeholder.jpg";
        } else {
            $firstImg = $eventImg->first();
            $eventImg = $firstImg->filename;
        }
        return view('eventPage', ['event' => $event, 'relatedEvent' => $relatedEvent, 'eventImg' => $eventImg]);
    }

    public function onSubmit(Request $request, String $id) {
        $answer = $request -> interested_btn;
        $model = Event::findOrFail(htmlspecialchars($id));
        if($answer == "Interested") {
            DB::table('events')
            ->where('id', htmlspecialchars($id))
            ->increment('interestRanking', 1);
        } else if($answer == "Not interested" && ($model -> interestRanking - 1 >= 0)) {
            DB::table('events')
            ->where('id', htmlspecialchars($id))
            ->increment('interestRanking', -1);
        }
        return view('eventPage', Event::findOrFail(htmlspecialchars($id)));
    }
}
