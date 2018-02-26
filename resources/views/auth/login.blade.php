@extends('layouts.backoffice.unauthenticated', [
    'heading' => 'Hello there, welcome back!',
])

@section('content')
<form method="POST" action="{{ route('login') }}" class="p-8">
    @csrf

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

    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <label>
                <input class="mr-2"
                        type="checkbox"
                        name="remember"
                        {{ old('remember') ? 'checked' : '' }}>

                <span class="uppercase text-grey-dark text-2xs font-bold tracking-wide" for="remember_me">Remember Me</span>
            </label>
        </div>

        <button type="submit"
                class="px-8 py-3 rounded text-white border-2 border-transparent bg-teal hover:border-teal hover:bg-transparent hover:text-teal">
            Login &rarr;
        </button>
    </div>
</form>
@endsection

@section('footer')
<div class="text-center">
    <a href="{{ route('password.request') }}"
        class="text-sm text-grey-darker py-1 underline tracking-wide hover:text-grey">
        Forgot Your password?
    </a>
</div>
@endsection
