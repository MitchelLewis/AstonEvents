@extends('layouts.app')

@section('content')
    <h1 class="text-center">Your events</h1>
    @foreach($events as $event)
        <div class="mt-3 mb-3 shadow border">
            <div class="ml-3 mt-3 mb-3">
                <h3> {{$event->eventName}} </h3>
                <p> {{$event->eventDescription }} </p>
                <p> {{date("F jS, Y", strtotime($event->dateTimeOfEvent)) }} </p>
                <a class="btn btn-primary" href="{{url('events')}}/{{$event->id}}">Details</a>
                
                <a class="btn btn-secondary" href="edit-event/{{$event->id}}">Edit event</a>
            </div>
        </div>
    @endforeach
@endsection
