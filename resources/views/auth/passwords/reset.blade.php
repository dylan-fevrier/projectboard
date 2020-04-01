@extends('layouts.app')


@section('content')
    <form action="{{ route('password.update') }}" class="card lg:w-1/2 lg:mx-auto" method="POST">

        @csrf

        <h1 class="text-2xl text-center mb-10">{{ __('Reset Password') }}</h1>

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="field mb-6">
            <label for="email" class="text-sm mb-2 block">{{ __('E-Mail Address') }}</label>

            <input type="email" name="email" class="input" id="email">

            @error('email')
            <span class="text-error italic font-normal text-sm" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="field mb-6">
            <label for="password" class="text-sm mb-2 block">{{ __('Password') }}</label>

            <input type="password" name="password" class="input" id="password">

            @error('password')
            <span class="text-error italic font-normal text-sm" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="field mb-6">
            <label for="password-confirm" class="text-sm mb-2 block">{{ __('Confirm Password') }}</label>

            <input type="password" name="password_confirmation" class="input" id="password-confirm">

            @error('password-confirm')
            <span class="text-error italic font-normal text-sm" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <button class="button" type="submit">{{ __('Reset Password') }}</button>

    </form>
@endsection
