@extends('layouts.app')
@section('content')
        <div class="mt-3">
            <h1 class="text-center">Organise event</h1>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif      

            <form enctype="multipart/form-data" method="POST" action="/edit-event/{{$event->id}}" class="mt-5 col-sm-6">
                @csrf

                <label for="name" class="mr-4 mt-2">Event name:</label>
                <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{$event->eventName}}">
                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror

                <label for="description" class="mr-4 mt-2">Event description:</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" cols="50">
                {{$event->eventDescription}}
                </textarea>
                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror

                <label for="category" class="mr-4 mt-2">Category</label>
                <select  class="form-control @error('category') is-invalid @enderror" name="category" id="category" >
                    <option value="Sport" @if($event -> eventCategory == 'Sport') selected @endif>Sport</option>
                    <option value="Culture" @if($event -> eventCategory == 'Culture') selected @endif>Culture</option>
                    <option value="Other" @if($event -> eventCategory == 'Other') selected @endif>Other</option>
                </select>
                @error('category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror

                <label for="location" class="mr-4 mt-2">Location</label>
                <input class="form-control @error('location') is-invalid @enderror" type="text" id="location" name="location" value="{{$event->location}}">
                @error('location')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror

                
                <label for="date" class="mr-4 mt-2">Date</label>
                <input class="form-control @error('date') is-invalid @enderror" type="date" id="date" name="date" value="{{explode(' ', $event->dateTimeOfEvent)[0]}}" >
                @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror

                <label for="image" class="mr-4 mt-2">Image</label>
                <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image">
                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror

            
                <input class="mt-3 mb-5 btn btn-primary" type="submit" value="Save event">
            </form>
        </div>
        @endsection
