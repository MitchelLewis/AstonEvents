@extends('layouts.app')
@section('content')
        <div class="mt-3">
            <h1 class="text-center">Welcome to Aston Events</h1>

            <form method="POST" action="/" class="border">
                @csrf

                <label for="rank" class="ml-3 mt-2">Ranking</label>
                <select id="rank" name="rank" class="ml-3 mt-2">
                    <option value="">------------</option>
                    <option value="1">Most popular</option>
                    <option value="-1">Least popular</option>
                </select>
                <br/>
                <label for="category" class="ml-3 mt-2">Category</label>
                <select id="category" name="category" class="mt-2 ml-3">
                    <option value="">-----</option>
                    <option value="sport">Sport</option>
                    <option value="culture">Culture</option>
                    <option value="other">Other</option>
                </select>

                <br/>
                <button type="submit" class="ml-3 mt-2 mb-3">
                    Filter
                </button>
            </form>
            <h2 class="ml-3 mt-3 mb-3">Events:</h2>

            @foreach($events as $event)
            <div class="mt-3 mb-3 shadow border">
                <div class="ml-3 mt-3 mb-3">
                    <h3> {{$event->eventName}} </h3>
                    <p> {{$event->eventDescription }} </p>
                    <p> {{date("F jS, Y", strtotime($event->dateTimeOfEvent)) }} </p>
                    <a class="btn btn-primary" href="{{url('events')}}/{{$event->id}}">Details</a>
                </div>
            </div>
            @endforeach
        </div>
        @endsection
