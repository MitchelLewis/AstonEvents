@extends('layouts.app')

@section('content')

        <div class="mt-3">
            <h1 class="text-center">{{$event->eventName}}</h1>

            <div class="col-md-offset-6">
                @foreach($eventImgs as $eventImg)
                    <img class="" src="{{ asset('files/' . $eventImg) }}" style="width:235px;height:200px;">
                @endforeach
            </div>
            <h2 class="ml-3 mt-3 mb-3">Event description</h2>
            <p class="ml-3 mt-3 mb-3">{{$event->eventDescription}}</p>

            <h2 class="ml-3 mt-3 mb-3">Event date/time</h2>
            <p class="ml-3 mt-3 mb-3">{{date("F jS, Y", strtotime($event->dateTimeOfEvent)) }}</p>
            
            <h2 class="ml-3 mt-3 mb-3">Category</h2>
            <p class="ml-3 mt-3 mb-3">{{$event->eventCategory}}</p>

            <h2 class="ml-3 mt-3 mb-3">Location</h2>
            <p class="ml-3 mt-3 mb-3">{{$event->location}}</p>

            <h2 class="ml-3 mt-3 mb-3">People interested</h2>
            <p class="ml-3 mt-3 mb-3">{{$event->interestRanking}}</p>

            @if($organiser !== null)
                <h2 class="ml-3 mt-3 mb-3">Organiser</h2>
                <p class="ml-3 mt-3 mb-3">{{$organiser->name}}</p>
                <a class="ml-3 btn btn-primary" href="/send-mail/{{$organiser->id}}">Send email</a>
            @endif

            @if($relatedEvent !== null)
                <h2 class="ml-3 mt-3 mb-3">Related Content</h2>
                <a class="ml-3 mt-3" href="/events/{{$relatedEvent->id}}">{{$relatedEvent->eventName}}</a>
            @endif

            <br/>
            <form method="post" action="/events/{{$event->id}}" class="mt-5">
                @csrf

                <input type="submit" name="interested_btn" value="Interested" class="ml-3 mb-3 btn btn-success btn-sm text-white" />
            </form>
        </div>
@endsection
