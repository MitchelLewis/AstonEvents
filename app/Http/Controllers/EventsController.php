<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function onPageLoad(Request $request, String $id) {
        return view('eventPage', Event::findOrFail($id));
    }
}
