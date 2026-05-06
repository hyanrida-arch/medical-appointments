<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information, photo, and email address.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Profile photo -->
        <div>
            <x-input-label :value="__('Profile Photo')" />
            <div class="mt-2 flex items-center gap-4">
                @if($user->profile_photo_url)
                    <img src="{{ $user->profile_photo_url }}" alt="Profile photo" class="w-20 h-20 rounded-full object-cover border border-gray-200 dark:border-gray-700">
                @else
                    <div class="w-20 h-20 rounded-full bg-brand-100 dark:bg-brand-900/40 flex items-center justify-center text-brand-600 dark:text-brand-300 text-xl font-bold">
                        {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}
                    </div>
                @endif
                <input type="file" id="profile_photo" name="profile_photo" accept="image/jpeg,image/png"
                    class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">JPG or PNG, max 2 MB.</p>
            <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
        </div>

        <!-- First name -->
        <div>
            <x-input-label for="first_name" :value="__('First name')" />
            <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $user->first_name)" required autofocus autocomplete="given-name" />
            <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
        </div>

        <!-- Last name -->
        <div>
            <x-input-label for="last_name" :value="__('Last name')" />
            <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name', $user->last_name)" required autocomplete="family-name" />
            <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <!-- Phone -->
        <div>
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" autocomplete="tel" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <!-- Doctor-specific fields -->
        @if($user->isDoctor())
            <div class="border-t dark:border-gray-700 pt-6">
                <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.doctor_profile') }}</h3>

                <div class="space-y-4">
                    <div>
                        <x-input-label for="specialization" :value="__('Specialization')" />
                        <x-text-input id="specialization" name="specialization" type="text" class="mt-1 block w-full"
                            :value="old('specialization', $user->doctorProfile->specialization ?? '')" />
                        <x-input-error class="mt-2" :messages="$errors->get('specialization')" />
                    </div>

                    <div>
                        <x-input-label for="consultation_fee" :value="__('Consultation fee (MAD)')" />
                        <x-text-input id="consultation_fee" name="consultation_fee" type="number" step="0.01" class="mt-1 block w-full"
                            :value="old('consultation_fee', $user->doctorProfile->consultation_fee ?? '')" />
                        <x-input-error class="mt-2" :messages="$errors->get('consultation_fee')" />
                    </div>

                    <div>
                        <x-input-label for="biography" :value="__('Biography')" />
                        <textarea id="biography" name="biography" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-600 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm">{{ old('biography', $user->doctorProfile->biography ?? '') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('biography')" />
                    </div>
                </div>
            </div>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
