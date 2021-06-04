<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Event;


class ChangeEventController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function onPageLoad(Request $request, String $id) {
        $event = DB::table('events')
        ->select()
        ->where('eventOrganiserId', Auth::id())
        ->where('id', $id)
        ->get();

        return view('editEvent', array('event' => $event->first() ));
    }

    public function endsWith($string, $endString)
    {
        $len = strlen($endString);
        if ($len == 0) {
            return true;
        }
        return (substr($string, -$len) === $endString);
    }   


    public function onSubmit(Request $request, String $id) {
        $event = DB::table('events')
        ->select()
        ->where('eventOrganiserId', Auth::id())
        ->where('id', $id)
        ->get();
        $data = $request->input();

        if($this->endsWith($data['imageUrl'], '.jpg' ) || $this->endsWith($data['imageUrl'], '.png' )) {

            if($event->first() != null) {
                $event = Event::find($id);
                $event -> eventName = htmlspecialchars($data['name']);
                $event -> eventCategory = htmlspecialchars($data['category']);
                $event -> location = htmlspecialchars($data['location']);
                $event -> eventDescription = htmlspecialchars($data['description']);
                $event -> dateTimeOfEvent = htmlspecialchars($data['date']);
                $event -> imgLocation = htmlspecialchars($data['imageUrl']);
                $event -> save();
                return redirect('/');
            }
        }
        
    }
}
