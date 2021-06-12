<?php

namespace App\Http\Controllers;

use App\Models\Event;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class CreateEventController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function onPageLoad(Request $request) {
        return view('organiseEvent', array('events' => Event::all()));
    }

    public function endsWith($string, $endString)
    {
        $len = strlen($endString);
        if ($len == 0) {
            return true;
        }
        return (substr($string, -$len) === $endString);
    }   

    protected function validator(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string'],
            'location' => ['required', 'string'],
            'description' => ['required', 'string'],
            'date' => ['required', 'date'],
            'image' => ['required', 'image', 'file']
        ]);
    }

    public function onSubmit(Request $request) {
        $data = $request->input();
        $idOfUser = Auth::id();
        $validationResult = $this->validator($request);
        if($validationResult->fails()) {
            return redirect()->action([CreateEventController::class, 'onPageLoad'])->withErrors($validationResult);
        } else {
            if($request->file('image')) {
                $file = $request->file('image');
                $filename = time().'_'.$file->getClientOriginalName();
       
                // File upload location
                $location = 'files';
       
                // Upload file
                $file->move($location,$filename);

                $event = Event::create([
                    'eventName' => htmlspecialchars($data['name']),
                    'eventCategory' => htmlspecialchars($data['category']),
                    'location' => htmlspecialchars($data['location']),
                    'eventDescription' => htmlspecialchars($data['description']),
                    'dateTimeOfEvent' => htmlspecialchars($data['date']),
                    'eventOrganiserId' => htmlspecialchars($idOfUser),
                    'relatedContent' => htmlspecialchars($data['relatedContent']),
                    'interestRanking' => '0'
                ]);

                Image::create([
                    'filename' => $filename,
                    'event_id' => $event->id
                ]);
                return redirect('/');
            }
        }
    }
}
