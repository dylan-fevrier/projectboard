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


@section('')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
