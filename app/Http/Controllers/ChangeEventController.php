<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Models\Event;
use App\Models\Image;

class ChangeEventController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function onPageLoad(Request $request, String $id) {
        $event = DB::table('events')
        ->select()
        ->where('eventOrganiserId', Auth::id())
        ->where('id', htmlspecialchars($id))
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


    public function onSubmit(Request $request, String $id) {
        $event = DB::table('events')
        ->select()
        ->where('eventOrganiserId', Auth::id())
        ->where('id', htmlspecialchars($id))
        ->get();
        $data = $request->input();
        $validationResult = $this->validator($request);
        
        if($validationResult->fails()) {
            return redirect('edit-event/' . $id)->withErrors($validationResult);
        }

        if($request->file('image')) {
            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();
   
            // File upload location
            $location = 'files';
   
            // Upload file
            $file->move($location,$filename);

            if($event->first() != null) {
                $event = Event::find(htmlspecialchars($id));
                $event -> eventName = htmlspecialchars($data['name']);
                $event -> eventCategory = htmlspecialchars($data['category']);
                $event -> location = htmlspecialchars($data['location']);
                $event -> eventDescription = htmlspecialchars($data['description']);
                $event -> dateTimeOfEvent = htmlspecialchars($data['date']);
                $event -> save();
                Image::updateOrCreate(
                    [
                        'event_id' => $event->id
                    ],
                    [
                    'filename' => $filename,
                    'event_id' => $event->id
                ]);
                return redirect('/');
            }
        }
        
    }
}
