@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-login">
                <div class="mb-10 text-gray-700 text-2xl text-center">{{ __('Register') }}</div>

                <div class="w-full">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-4">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="bg-white focus:outline-none focus:shadow-outline border border-gray-100 rounded-lg py-2 px-4 block w-full appearance-none leading-normal mb-5 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-4">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="bg-white focus:outline-none focus:shadow-outline border border-gray-100 rounded-lg py-2 px-4 block w-full appearance-none leading-normal mb-5  @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="block text-gray-700 text-sm font-bold mb-4">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="bg-white focus:outline-none focus:shadow-outline border border-gray-100 rounded-lg py-2 px-4 block w-full appearance-none leading-normal mb-5 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="block text-gray-700 text-sm font-bold mb-4">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="bg-white focus:outline-none focus:shadow-outline border border-gray-100 rounded-lg py-2 px-4 block w-full appearance-none leading-normal mb-5" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="button border-0">
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
