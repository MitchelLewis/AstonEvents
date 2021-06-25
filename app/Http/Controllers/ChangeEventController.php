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
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Shows the page for the given event, if the user logged in is not the 'owner' of the event, then
     * they are redirected back to the home page.
     *
     * @param  Request $request 
     * @param  String $id 
     */
    public function onPageLoad(Request $request, String $id) {
        $event = DB::table('events')
        ->select()
        ->where('eventOrganiserId', Auth::id())
        ->where('id', htmlspecialchars($id))
        ->get();
        
        if(empty($event->first())) {
            return redirect()->route('home');
        }

        return view('editEvent', ['event' => $event->first(), 'events' => Event::all()]);
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
     * POST handler for changing event. Similar to the creation of an event, changing requires the same fields
     * to be present in the request params. Passing a custom message for when the file uploaded is not an image.
     * For events that have images, these images are deleted and reuploaded and assigned.
     * Redirects to /home on success.
     *
     * @param  Request $request 
     * @param  String $id 
     */
    public function onSubmit(Request $request, String $id) {
        $event = DB::table('events')
        ->select()
        ->where('eventOrganiserId', Auth::id())
        ->where('id', htmlspecialchars($id))
        ->get();
        $data = $request->input();
        $customMessages = [
            'image' => 'All image files must be an image e.g. .png, .jpg.'
        ];
        $validationResult = $this->validator($request, $customMessages);        
        if($validationResult->fails()) {
            return redirect('edit-event/' . $id)->withErrors($validationResult);
        }

        if($request->file('images')) {
            $files = $request->file('images');

            if($event->first() !== null) {
                $event = Event::find(htmlspecialchars($id));
                $event -> eventName = htmlspecialchars($data['name']);
                $event -> eventCategory = htmlspecialchars($data['category']);
                $event -> location = htmlspecialchars($data['location']);
                $event -> eventDescription = htmlspecialchars($data['description']);
                $event -> dateTimeOfEvent = htmlspecialchars($data['date']);
                if(htmlspecialchars($data['relatedContent']) !== "-1") {
                    $event -> relatedContent = htmlspecialchars($data['relatedContent']);
                } else {
                    $event -> relatedContent = NULL;
                }

                $event -> save();
                Image::where('event_id', $id)->delete();
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
