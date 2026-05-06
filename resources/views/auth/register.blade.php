<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- First name -->
        <div>
            <x-input-label for="first_name" :value="__('First name')" />
            <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="given-name" />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>

        <!-- Last name -->
        <div class="mt-4">
            <x-input-label for="last_name" :value="__('Last name')" />
            <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autocomplete="family-name" />
            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone (optional) -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone (optional)')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('I am a...')" />
            <select id="role" name="role" required
                class="block mt-1 w-full border-gray-300 dark:border-gray-600 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm"
                onchange="toggleDoctorFields()">
                <option value="">-- Select role --</option>
                <option value="patient" {{ old('role') === 'patient' ? 'selected' : '' }}>{{ __('messages.patient_label') }}</option>
                <option value="doctor" {{ old('role') === 'doctor' ? 'selected' : '' }}>Doctor</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Doctor-only fields (hidden by default) -->
        <div id="doctor-fields" style="display: {{ old('role') === 'doctor' ? 'block' : 'none' }};">
            <div class="mt-4">
                <x-input-label for="specialization" :value="__('Specialization')" />
                <x-text-input id="specialization" class="block mt-1 w-full" type="text" name="specialization" :value="old('specialization')" />
                <x-input-error :messages="$errors->get('specialization')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="consultation_fee" :value="__('Consultation fee (MAD)')" />
                <x-text-input id="consultation_fee" class="block mt-1 w-full" type="number" step="0.01" name="consultation_fee" :value="old('consultation_fee')" />
                <x-input-error :messages="$errors->get('consultation_fee')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="biography" :value="__('Biography')" />
                <textarea id="biography" name="biography" rows="3"
                    class="block mt-1 w-full border-gray-300 dark:border-gray-600 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm">{{ old('biography') }}</textarea>
                <x-input-error :messages="$errors->get('biography')" class="mt-2" />
            </div>
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
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        function toggleDoctorFields() {
            const role = document.getElementById('role').value;
            const doctorFields = document.getElementById('doctor-fields');
            doctorFields.style.display = role === 'doctor' ? 'block' : 'none';
        }
    </script>
</x-guest-layout>
