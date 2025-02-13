<x-guest-layout>
<div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-green-300 to-green-600 p-4">
        <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            
            <!-- Logo or Image -->
            <div class="flex justify-center mb-6">
                <img src="logo.jpg" alt="logo" class="w-20 h-20 rounded-full">
            </div>

            <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-white mb-4">
                {{ __('Create an Account') }}
            </h2>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                        type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500" />
                </div>

                <!-- Username -->
                <div>
                    <x-input-label for="username" :value="__('Username')" />
                    <x-text-input id="username" class="block mt-1 w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                        type="text" name="username" :value="old('username')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('username')" class="mt-2 text-red-500" />
                </div>

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                        type="email" name="email" :value="old('email')" required autocomplete="email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
                </div>

                <!-- Password with Toggle -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <div class="relative">
                        <x-text-input id="password" class="block mt-1 w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 pr-10" 
                            type="password" name="password" required autocomplete="new-password" />
                        <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-2 flex items-center">
                            <svg id="password-icon" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"></path>
                                <path d="M2.25 12s3.75-7.5 9.75-7.5 9.75 7.5 9.75 7.5-3.75 7.5-9.75 7.5S2.25 12 2.25 12z"></path>
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
                </div>

                <!-- Confirm Password with Toggle -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <div class="relative">
                        <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 pr-10" 
                            type="password" name="password_confirmation" required autocomplete="new-password" />
                        <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-2 flex items-center">
                            <svg id="password_confirmation-icon" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"></path>
                                <path d="M2.25 12s3.75-7.5 9.75-7.5 9.75 7.5 9.75 7.5-3.75 7.5-9.75 7.5S2.25 12 2.25 12z"></path>
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500" />
                </div>

                <!-- Already Registered & Submit Button -->
                <div class="flex flex-col items-center gap-4 mt-4">
                    <a class="text-sm text-blue-600 dark:text-blue-400 hover:underline" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-primary-button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg shadow-md transition-all duration-300 flex justify-center">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            const icon = document.getElementById(id + "-icon");
            if (input.type === "password") {
                input.type = "text";
                icon.setAttribute("stroke", "blue");
            } else {
                input.type = "password";
                icon.setAttribute("stroke", "currentColor");
            }
        }
    </script>
</x-guest-layout>
