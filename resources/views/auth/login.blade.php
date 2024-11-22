<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-blue-50">
        <!-- Card -->
        <div class="w-full max-w-md bg-white shadow-lg rounded-lg px-8 py-6">
            <!-- Título -->
            <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">{{ __('Log in') }}</h2>

            <!-- Formulario -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-blue-600 font-medium mb-2">{{ __('Email') }}</label>
                    <input id="email" 
                           type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus 
                           autocomplete="username" 
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-blue-600 font-medium mb-2">{{ __('Password') }}</label>
                    <input id="password" 
                           type="password" 
                           name="password" 
                           required 
                           autocomplete="current-password" 
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
                </div>

                <!-- Remember Me -->
                <div class="mb-4 flex items-center">
                    <input id="remember_me" 
                           type="checkbox" 
                           name="remember" 
                           class="rounded text-blue-500 focus:ring-blue-400">
                    <label for="remember_me" class="ml-2 text-sm text-blue-600">{{ __('Remember me') }}</label>
                </div>

                <!-- Forgot Password -->
                <div class="flex justify-between items-center mb-4">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" 
                           class="text-sm text-blue-500 hover:underline">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <a href="{{ route('register') }}" 
                       class="text-sm text-blue-500 hover:underline">
                        {{ __('Register') }}
                    </a>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    {{ __('Log in') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
