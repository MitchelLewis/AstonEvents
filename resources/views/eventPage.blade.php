@extends('layouts.app')

@section('content')

        <div class="mt-3">
            <h1 class="text-center">{{$eventName}}</h1>

            <img class="ml-3 mt-3 mb-3 float-right" src="{{$imgLocation}}" style="width:235px;height:200px;">

            <h2 class="ml-3 mt-3 mb-3">Event description</h2>
            <p class="ml-3 mt-3 mb-3">{{$eventDescription}}</p>

            <h2 class="ml-3 mt-3 mb-3">Event date/time</h2>
            <p class="ml-3 mt-3 mb-3">{{date("F jS, Y", strtotime($dateTimeOfEvent)) }}</p>
            
            <h2 class="ml-3 mt-3 mb-3">Category</h2>
            <p class="ml-3 mt-3 mb-3">{{$eventCategory}}</p>

            <h2 class="ml-3 mt-3 mb-3">Location</h2>
            <p class="ml-3 mt-3 mb-3">{{$location}}</p>

            <h2 class="ml-3 mt-3 mb-3">People interested</h2>
            <p class="ml-3 mt-3 mb-3">{{$interestRanking}}</p>

            <form method="post" action="/events/{{$id}}">
                @csrf

                <input type="submit" name="interested_btn" value="Interested" class="ml-3 mb-3 btn btn-success btn-sm text-white" />
                <input type="submit" name="interested_btn" value="Not interested" class="ml-3 mb-3 btn btn-danger btn-sm text-white" />
            </form>
        </div>
@endsection
