@extends('layouts.backoffice.unauthenticated', [
    'heading' => 'Create a New Password',
])

@section('content')
<form method="POST" action="{{ route('password.request') }}" class="p-8">
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    <div class="mb-8">
        <div class="uppercase text-grey-dark text-2xs font-bold mb-2 tracking-wide">Your E-mail</div>

        <input class="px-4 py-3 border-2 rounded w-full text-grey-darkest focus:border-teal-light {{ $errors->has('email') ? 'border-red' : '' }}"
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Your E-mail"
                autofocus
                required>

        @if ($errors->has('email'))
            <div class="text-red text-sm py-2">{{ $errors->first('email') }}</div>
        @endif
    </div>

    <div class="mb-8">
        <div class="uppercase text-grey-dark text-2xs font-bold mb-2 tracking-wide">Password</div>

        <input class="px-4 py-3 border-2 rounded w-full text-grey-darkest focus:border-teal-light {{ $errors->has('password') ? 'border-red' : '' }}"
                type="password"
                name="password"
                placeholder="Your Password"
                required>

        @if ($errors->has('password'))
            <div class="text-red text-sm py-2">{{ $errors->first('password') }}</div>
        @endif
    </div>

    <div class="mb-8">
        <div class="uppercase text-grey-dark text-2xs font-bold mb-2 tracking-wide">Confirm Password</div>

        <input class="px-4 py-3 border-2 rounded w-full text-grey-darkest focus:border-teal-light {{ $errors->has('password_confirmation') ? 'border-red' : '' }}"
                type="password"
                name="password_confirmation"
                placeholder="Your Password"
                required>

        @if ($errors->has('password_confirmation'))
            <div class="text-red text-sm py-2">{{ $errors->first('password_confirmation') }}</div>
        @endif
    </div>

    <div class="flex items-center justify-center">
        <button type="submit"
                class="px-8 py-3 rounded text-white border-2 border-transparent bg-teal hover:border-teal hover:bg-transparent hover:text-teal">
            Reset Password
        </button>
    </div>
</form>
@endsection
