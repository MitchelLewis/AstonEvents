@extends('layouts.app')
@section('content')
    <div class="mt-3">
        <h1 class="text-center">Welcome to Aston Events</h1>

        <h2 class="ml-3">Sending an email to {{$user->name}} ({{ $user->email }})</h2>

        <form method="POST" action="/send-mail" class="mt-5 col-sm-6">
                @csrf
                <input type="hidden" id="recipientId" name="recipientId" value="{{$user->id}}">

                <label for="msg" class="mr-4 mt-2">Message:</label>
                <textarea class="form-control @error('msg') is-invalid @enderror" id="msg" name="msg" rows="4" cols="50" required></textarea>
                @error('msg')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            
                <input class="mt-3 mb-5 btn btn-primary" type="submit" value="Send">
            </form>
    </div>
@endsection
