@extends('layouts.app')


@section('content')
    <form action="{{ route('password.email') }}" class="card lg:w-1/2 lg:mx-auto" method="POST">

        <h1 class="text-2xl text-center mb-10">Password reset</h1>

        @if (session('status'))
            <div class="text-info mb-4" role="alert">
                {{ session('status') }}
            </div>
        @endif

        @csrf

        <div class="field mb-6">
            <label for="email" class="text-sm mb-2 block">{{ __('E-Mail Address') }}</label>

            <input type="text" name="email" class="input" id="email">

            @error('email')
                <span class="text-error italic font-normal text-sm" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <button class="button" type="submit">{{ __('Send Password Reset Link') }}</button>

    </form>
@endsection
