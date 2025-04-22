<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="auth-form-group">
            <label for="name" class="auth-label">{{ __('Name') }}</label>
            <input id="name" class="auth-input bg-gray-800 border-gray-700 text-white focus:border-blue-500 focus:ring-blue-500" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
            @error('name')
                <div class="auth-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="auth-form-group">
            <label for="email" class="auth-label">{{ __('Email') }}</label>
            <input id="email" class="auth-input bg-gray-800 border-gray-700 text-white focus:border-blue-500 focus:ring-blue-500" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
            @error('email')
                <div class="auth-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="auth-form-group">
            <label for="password" class="auth-label">{{ __('Password') }}</label>
            <input id="password" class="auth-input bg-gray-800 border-gray-700 text-white focus:border-blue-500 focus:ring-blue-500" type="password" name="password" required autocomplete="new-password" />
            @error('password')
                <div class="auth-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="auth-form-group">
            <label for="password_confirmation" class="auth-label">{{ __('Confirm Password') }}</label>
            <input id="password_confirmation" class="auth-input bg-gray-800 border-gray-700 text-white focus:border-blue-500 focus:ring-blue-500" type="password" name="password_confirmation" required autocomplete="new-password" />
            @error('password_confirmation')
                <div class="auth-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="auth-footer">
            <a class="auth-link" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <button type="submit" class="auth-button">
                {{ __('Register') }}
            </button>
        </div>
    </form>
</x-guest-layout>
