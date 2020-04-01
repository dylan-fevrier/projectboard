@extends('layouts.app')

@section('content')
    <form action="{{ route('login') }}" class="card lg:w-1/2 lg:mx-auto" method="POST">

        <h1 class="text-2xl text-center mb-10">Login</h1>

        @csrf

        <div class="field mb-6">
            <label for="" class="text-sm mb-2 block">Email</label>
            <div class="form-control">
                <input type="text" name="email" class="input">
            </div>
        </div>

        <div class="field mb-6">
            <label for="" class="text-sm mb-2 block">Password</label>
            <div class="form-control">
                <input type="password" name="password" class="input">
            </div>
        </div>

        <div class="">
            <button class="button" type="submit">Login</button>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="ml-2 text-default">Forgot your password ?</a>
            @endif
        </div>

    </form>
@endsection
