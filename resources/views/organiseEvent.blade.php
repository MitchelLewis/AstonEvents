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

            <form  enctype="multipart/form-data" method="POST" action="/organise-event" class="mt-5 col-sm-6">
                @csrf

                <label for="name" class="mr-4 mt-2">Event name:</label>
                <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" required>
                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror

                <label for="description" class="mr-4 mt-2">Event description:</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" cols="50" required></textarea>
                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror

                <label for="category" class="mr-4 mt-2">Category</label>
                <select  class="form-control @error('category') is-invalid @enderror" name="category" id="category" required>
                    <option value="Sport">Sport</option>
                    <option value="Culture">Culture</option>
                    <option value="Other">Other</option>
                </select>
                @error('category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror

                <label for="location" class="mr-4 mt-2">Location</label>
                <input class="form-control @error('location') is-invalid @enderror" type="text" id="location" name="location" required>
                @error('location')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror

                
                <label for="date" class="mr-4 mt-2">Date of event</label>
                <input class="form-control @error('location') is-invalid @enderror" type="date" id="date" name="date" required>
                @error('location')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror

                <label for="image" class="mr-4 mt-2">Image</label>
                <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" required>
                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror

                <label for="relatedContent" class="mr-4 mt-2">Related Content</label>
                <select class="form-control @error('category') is-invalid @enderror" name="relatedContent" id="relatedContent" required>
                    <option value="-1">None</option>
                    @foreach($events as $event)
                        <option value="{{$event->id}}">{{$event->eventName}}</option>
                    @endforeach
                </select>

            
                <input class="mt-3 mb-5 btn btn-primary" type="submit" value="Create event">
            </form>
        </div>
        @endsection
