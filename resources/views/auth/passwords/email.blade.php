@extends('layouts.backoffice.unauthenticated', [
    'heading' => 'Forgot You Password?',
])

@section('content')
<form method="POST" action="{{ route('password.email') }}" class="p-8">
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

    <div class="flex items-center justify-center">
        <button type="submit"
                class="px-8 py-3 rounded text-white border-2 border-transparent bg-teal hover:border-teal hover:bg-transparent hover:text-teal">
            Send Password Reset Link
        </button>
    </div>
</form>
@endsection

@section('footer')
<div class="text-center">
    <a href="{{ route('login') }}"
        class="text-sm text-grey-darker py-1 underline tracking-wide hover:text-grey">
        &larr; Back to Login
    </a>
</div>
@endsection
