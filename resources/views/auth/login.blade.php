@extends('layouts.app')

@section('content')
<div class="container mx-auto flex">
    <div class="card-login">
        <div class="mb-10 text-gray-700 text-2xl text-center">{{ __('Login') }}</div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="w-full">
                    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                        <div class="mb-8">
                        <label class="block text-gray-700 text-sm font-bold mb-4" for="username">
                            {{ __('E-Mail Address') }}
                        </label>
                        <input id="email" type="email" class="bg-white focus:outline-none focus:shadow-outline border border-gray-100 rounded-lg py-2 px-4 block w-full appearance-none leading-normal @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="text-red-100" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror    
                        </div>
                        <div class="mb-8">
                        <label class="block text-gray-700 text-sm font-bold mb-4" for="password">
                            {{ __('Password') }}
                        </label>
                            <input id="password" type="password" class="bg-white focus:outline-none focus:shadow-outline border border-gray-100 rounded-lg py-2 px-4 block w-full appearance-none leading-normal @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            {{-- <p class="text-xs italic">Please choose a password.</p> --}}
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-6">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label text-gray-700" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                        <div class="flex items-center justify-between">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline border-0" type="submit">
                            {{ __('Login') }}
                        </button>
                        <div class="mt-6">
                            @if (Route::has('password.request'))
                                <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                        </div>
                    </form>
                </div>
            </form>
    </div>
</div>
@endsection
