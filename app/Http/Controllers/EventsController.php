<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class EventsController extends Controller
{
    /**
     * Shows the event page for a particular event found via the parameter $id. Finding the related event (if exists) as well as the image(s) assigned
     * to the event.
     * 
     * @param String $id - ID of the event
     */
    public function onPageLoad(String $id) {
        $event = Event::findOrFail($id);
        $relatedContentId = $event->relatedContent;
        $relatedEvent = null;
        if($relatedContentId !== NULL) {
            $relatedEvent = Event::findOrFail($relatedContentId);
        }
        $eventImgs = Image::select('filename')->where('event_id', $event->id)->get()->toArray();
        $eventOrganiser = User::findOrFail($event->eventOrganiserId);
        if(empty($eventImgs)) {
            $eventImgs = ["event_placeholder.jpg"];
        } else {
            $eventImgs = array_column($eventImgs, 'filename');
        }
        return view('eventPage', ['event' => $event, 'relatedEvent' => $relatedEvent, 'eventImgs' => $eventImgs, 'organiser' => $eventOrganiser]);
    }

    /**
     * Handles the POST request of specifying interest in an event.
     * If the user has already shown interest in this event (session key), then the count will not increment.
     * If not, the count in the database is updated and the page is refreshed (adding the key to the session to prevent multiple increments).
     * 
     * @param Request $request
     * @param String $id - ID of the event
     */
    public function onSubmit(Request $request, String $id) {
        $answer = $request -> interested_btn;
        if($answer === "Interested" && !in_array($id, $request->session()->get('eventInterest', []))) {
            DB::table('events')
            ->where('id', htmlspecialchars($id))
            ->increment('interestRanking', 1);
            $request->session()->push('eventInterest', $id);
        }
        
        return $this->onPageLoad($id);
    }
}
