<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('messages.profile_information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('messages.profile_info_subtitle') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Profile Photo -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                {{ __('messages.profile_photo') }}
            </label>
            <div class="flex items-center gap-4">
                @if($user->profile_photo_url)
                    <img src="{{ $user->profile_photo_url }}" alt="Photo" class="w-20 h-20 rounded-full object-cover">
                @else
                    <div class="w-20 h-20 rounded-full bg-brand-100 dark:bg-brand-900/40 flex items-center justify-center text-brand-600 dark:text-brand-300 text-xl font-bold">
                        {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}
                    </div>
                @endif
                <input type="file" name="profile_photo" accept="image/jpeg,image/png,image/jpg"
                    class="block text-sm text-gray-700 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-brand-50 dark:file:bg-brand-900/30 file:text-brand-700 dark:file:text-brand-300 hover:file:bg-brand-100 dark:hover:file:bg-brand-900/50">
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ __('messages.photo_upload_help') }}</p>
            @error('profile_photo')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- First name -->
        <div>
            <x-input-label for="first_name" :value="__('messages.first_name')" />
            <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $user->first_name)" required autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
        </div>

        <!-- Last name -->
        <div>
            <x-input-label for="last_name" :value="__('messages.last_name')" />
            <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name', $user->last_name)" required />
            <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('messages.email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <!-- Phone -->
        <div>
            <x-input-label for="phone" :value="__('messages.phone')" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <!-- Doctor profile section (only if user is a doctor) -->
        @if($user->isDoctor())
            <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4">
                    {{ __('messages.doctor_profile_section') }}
                </h3>

                <div class="space-y-4">
                    <div>
                        <x-input-label for="specialization" :value="__('messages.specialization')" />
                        <x-text-input id="specialization" name="specialization" type="text" class="mt-1 block w-full"
                            :value="old('specialization', $user->doctorProfile->specialization ?? '')" />
                        <x-input-error class="mt-2" :messages="$errors->get('specialization')" />
                    </div>

                    <div>
                        <x-input-label for="consultation_fee" :value="__('messages.consultation_fee')" />
                        <x-text-input id="consultation_fee" name="consultation_fee" type="number" step="0.01" min="0" class="mt-1 block w-full"
                            :value="old('consultation_fee', $user->doctorProfile->consultation_fee ?? '')" />
                        <x-input-error class="mt-2" :messages="$errors->get('consultation_fee')" />
                    </div>

                    <div>
                        <x-input-label for="biography" :value="__('messages.biography')" />
                        <textarea id="biography" name="biography" rows="4"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500">{{ old('biography', $user->doctorProfile->biography ?? '') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('biography')" />
                    </div>
                </div>
            </div>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('messages.save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('messages.saved') }}</p>
            @endif
        </div>
    </form>
</section>