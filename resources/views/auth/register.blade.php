@extends('layouts.app')
@section('content')
        <div class="mt-3">
            <h1 class="text-center">Register to become an Organiser!</h1>

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif      

            <form  method="POST" action="{{ route('register') }}" class="mt-5 col-sm-6">
                @csrf

                <label for="name" class="mr-4 mt-2">Name:</label>
                <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name">
                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror

                <label for="email" class="mr-4 mt-2">Email address:</label>
                <input class="form-control @error('email') is-invalid @enderror" type="email" id="email" name="email">
                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror

                <label for="number" class="mr-4 mt-2">Phone number:</label>
                <input class="form-control @error('number') is-invalid @enderror" type="tel" id="number" name="number">
                @error('number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
                
                <label for="password" class="mr-4 mt-2">Password:</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror

                <label for="password-confirm" class="mr-4 mt-2">Confirm Password</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                <input class="mt-3 mb-5 btn btn-primary" type="submit" value="Register">
            </form>
        </div>
@endsection