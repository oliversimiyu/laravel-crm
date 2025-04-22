<x-guest-layout>
    <!-- Session Status -->
    @if (session('status'))
        <div class="auth-status">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="auth-form-group">
            <label for="email" class="auth-label">{{ __('Email') }}</label>
            <input id="email" class="auth-input bg-gray-800 border-gray-700 text-white focus:border-blue-500 focus:ring-blue-500" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
            @error('email')
                <div class="auth-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="auth-form-group">
            <label for="password" class="auth-label">{{ __('Password') }}</label>
            <input id="password" class="auth-input bg-gray-800 border-gray-700 text-white focus:border-blue-500 focus:ring-blue-500" type="password" name="password" required autocomplete="current-password" />
            @error('password')
                <div class="auth-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="auth-form-group">
            <label for="remember_me" class="auth-checkbox-label">
                <input id="remember_me" type="checkbox" class="auth-checkbox" name="remember">
                <span>{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="auth-footer">
            @if (Route::has('password.request'))
                <a class="auth-link" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <button type="submit" class="auth-button">
                {{ __('Log in') }}
            </button>
        </div>
    </form>
</x-guest-layout>
