@extends('layouts.app')

@section('content')
    <form action="{{ route('register') }}" class="card lg:w-1/2 lg:mx-auto" method="POST">

        <h1 class="text-2xl text-center mb-10">Register</h1>

        @csrf

        <div class="field mb-6">
            <label for="email" class="text-sm mb-2 block">Email</label>
            <div class="form-control">
                <input type="text" name="email" class="input" id="email">
            </div>
        </div>

        <div class="field mb-6">
            <label for="name" class="text-sm mb-2 block">Name</label>
            <div class="form-control">
                <input type="text" name="name" class="input" id="name">
            </div>
        </div>

        <div class="field mb-6">
            <label for="password-confirm" class="text-sm mb-2 block">Password</label>
            <div class="form-control">
                <input type="password" name="password" class="input" id="password">
            </div>
        </div>

        <div class="field mb-6">
            <label for="password-confirm" class="text-sm mb-2 block">Confirm password</label>
            <div class="form-control">
                <input type="password" name="password-confirm" class="input" id="password-confirm">
            </div>
        </div>

        <div class="">
            <button class="button button-blue" type="submit">Register</button>
        </div>

    </form>
@endsection

@section('')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

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
                                    {{ __('Register') }}
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
