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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Shows the create event page, passing in all events so that the user can select related content.
     *
     * @param  Request $request 
     * @param  String $id 
     */
    public function onPageLoad(Request $request) {
        return view('organiseEvent', ['events' => Event::all()]);
    }

    /**
     * Get a validator for an incoming request.
     *
     * @param  Request  $request
     * @param  array  $messages
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(Request $request, array $messages)
    {
        return Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string'],
            'location' => ['required', 'string'],
            'description' => ['required', 'string'],
            'date' => ['required', 'date'],
            'images' => ['required'],
            'images.*' => ['required', 'image', 'file']
        ], $messages);
    }

    /**
     * Handles the POST request for a new event. Same as changing event in terms of validation. If the validation fails, error fields are shown.
     * Creates a new App\Models\Event and App\Models\Image. 
     *
     * @param  Request $request 
     */
    public function onSubmit(Request $request) {
        $data = $request->input();
        $idOfUser = Auth::id();
        $customMessages = [
            'image' => 'All image files must be an image e.g. .png, .jpg.'
        ];
        $validationResult = $this->validator($request, $customMessages);
        if($validationResult->fails()) {
            return redirect()->action([CreateEventController::class, 'onPageLoad'])->withErrors($validationResult);
        } else {
            if($request->file('images')) {
                $files = $request->file('images');
                $eventData = [
                    'eventName' => htmlspecialchars($data['name']),
                    'eventCategory' => htmlspecialchars($data['category']),
                    'location' => htmlspecialchars($data['location']),
                    'eventDescription' => htmlspecialchars($data['description']),
                    'dateTimeOfEvent' => htmlspecialchars($data['date']),
                    'eventOrganiserId' => htmlspecialchars($idOfUser),
                    'interestRanking' => '0'
                ];

                if(htmlspecialchars($data['relatedContent']) !== "-1") {
                    $eventData['relatedContent'] =  htmlspecialchars($data['relatedContent']);
                }

                $event = Event::create($eventData);
                foreach($files as $file) {
                    $filename = time().'_'.$file->getClientOriginalName();
                    $location = 'files';
                    $file->move($location,$filename);   
                    Image::create([
                        'filename' => $filename,
                        'event_id' => $event->id
                    ]);                 
                }
                return redirect('/');
            }
        }
    }
}
