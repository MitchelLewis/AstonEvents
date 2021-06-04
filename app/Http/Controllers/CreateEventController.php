<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class CreateEventController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function onPageLoad(Request $request) {
        return view('organiseEvent');
    }

    public function endsWith($string, $endString)
    {
        $len = strlen($endString);
        if ($len == 0) {
            return true;
        }
        return (substr($string, -$len) === $endString);
    }   

    public function onSubmit(Request $request) {
        $data = $request->input();
        $idOfUser = Auth::id();
        if($this->endsWith($data['imageUrl'], '.jpg' ) || $this->endsWith($data['imageUrl'], '.png' )) {
            Event::create([
                'eventName' => $data['name'],
                'eventCategory' => $data['category'],
                'location' => $data['location'],
                'eventDescription' => $data['description'],
                'dateTimeOfEvent' => $data['date'],
                'eventOrganiserId' => $idOfUser,
                'imgLocation' => $data['imageUrl'],
                'interestRanking' => '0'
            ]);
            return redirect('/');
        }
    }
}
