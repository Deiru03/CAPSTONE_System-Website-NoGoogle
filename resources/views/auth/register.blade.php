<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- User Type -->
        <div class="mt-4">
            <x-input-label for="user_type" :value="__('User Type')" />
                <select id="user_type" name="user_type" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="Faculty" selected>Faculty</option>
                    <option value="Admin">Admin</option>
                </select>
            <x-input-error :messages="$errors->get('user_type')" class="mt-2" />
        </div>

        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Program -->
        <div class="mt-4">
            <x-input-label for="program" :value="__('Program')" />
            <x-text-input id="program" class="block mt-1 w-full" type="text" name="program" :value="old('program')" required autocomplete="program" />
            <x-input-error :messages="$errors->get('program')" class="mt-2" />
        </div>
        
        <!-- Position -->
        <div class="mt-4">
            <x-input-label for="position" :value="__('Position')" />
            <select id="position" name="position" :value="old('position')" required autocomplete="position" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="Permanent">Permanent</option>
                <option value="Temporary">Temporary</option>
                <option value="Part-Timer">Part-Timer</option>
            </select>
            <x-input-error :messages="$errors->get('position')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
