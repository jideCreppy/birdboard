@extends('layouts.app')

@section('content')
<div class="mx-auto">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-login">
                <div class="text-gray-700 text-2xl text-center mb-8">{{ __('Reset Password') }}</div>

                <div class="">
                    @if (session('status'))
                        <div class="my-6 bg-teal-100 p-6" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="text-md text-gray-700">{{ __('E-Mail Address') }}</label>

                            <div class="mt-3">
                                <input id="email" type="email" class=" bg-white focus:outline-none focus:shadow-outline border border-gray-300 rounded-lg py-2 px-4 block w-full appearance-none leading-normal @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="text-red-100" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="my-6">
                            <div class="">
                                <button type="submit" class="button border-0">
                                    {{ __('Send Password Reset Link') }}
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
