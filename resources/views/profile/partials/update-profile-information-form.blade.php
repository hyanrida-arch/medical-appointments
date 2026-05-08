<section>
    <header class="mb-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
            {{ __('messages.profile_information') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('messages.profile_info_subtitle') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Profile Photo (single, clean section) -->
        <div class="pb-6 border-b border-gray-200 dark:border-gray-700">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                {{ __('messages.profile_photo') }}
            </label>

            <div class="flex items-center gap-5">
                <!-- Avatar -->
                @if($user->profile_photo_url)
                    <img src="{{ $user->profile_photo_url }}" alt="Photo"
                         class="w-24 h-24 rounded-full object-cover ring-4 ring-brand-100 dark:ring-brand-900/40 shadow-md">
                @else
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white text-2xl font-bold shadow-md">
                        {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}
                    </div>
                @endif

                <!-- File input + actions -->
                <div class="flex-1">
                    <input type="file" name="profile_photo" accept="image/jpeg,image/png,image/jpg"
                           class="block w-full text-sm text-gray-700 dark:text-gray-300
                                  file:mr-4 file:py-2.5 file:px-4
                                  file:rounded-lg file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-brand-50 dark:file:bg-brand-900/30
                                  file:text-brand-700 dark:file:text-brand-300
                                  hover:file:bg-brand-100 dark:hover:file:bg-brand-900/50
                                  cursor-pointer">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                        {{ __('messages.photo_upload_help') }}
                    </p>

                    @if($user->profile_photo)
                        <button type="button"
                                onclick="if(confirm('{{ __('messages.confirm_delete_photo') }}')) document.getElementById('delete-photo-form').submit();"
                                class="mt-3 inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium text-red-600 dark:text-red-400 hover:text-white hover:bg-red-600 dark:hover:bg-red-600 rounded-md transition border border-red-200 dark:border-red-800">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/>
                            </svg>
                            {{ __('messages.delete_photo') }}
                        </button>
                    @endif
                </div>
            </div>

            @error('profile_photo')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Name fields (two columns) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <x-input-label for="first_name" :value="__('messages.first_name')" />
                <x-text-input id="first_name" name="first_name" type="text"
                              class="mt-1 block w-full"
                              :value="old('first_name', $user->first_name)" required autofocus />
                <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
            </div>

            <div>
                <x-input-label for="last_name" :value="__('messages.last_name')" />
                <x-text-input id="last_name" name="last_name" type="text"
                              class="mt-1 block w-full"
                              :value="old('last_name', $user->last_name)" required />
                <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
            </div>
        </div>

        <!-- Email + Phone (two columns) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <x-input-label for="email" :value="__('messages.email')" />
                <x-text-input id="email" name="email" type="email"
                              class="mt-1 block w-full"
                              :value="old('email', $user->email)" required />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <div>
                <x-input-label for="phone" :value="__('messages.phone')" />
                <div class="mt-1 flex rounded-md shadow-sm">
                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-sm">
                        +212
                    </span>
                    <input id="phone" name="phone" type="tel"
                           value="{{ old('phone', preg_replace('/^\+?212/', '', $user->phone ?? '')) }}"
                           placeholder="600000000"
                           class="flex-1 block w-full rounded-none rounded-r-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-brand-500 focus:ring-brand-500 text-sm">
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>
        </div>

        <!-- Doctor profile section (only if user is a doctor) -->
        @if($user->isDoctor())
            <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                <h3 class="text-md font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                    🩺 {{ __('messages.doctor_profile_section') }}
                </h3>

                <div class="space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="specialization" :value="__('messages.specialization')" />
                            <x-text-input id="specialization" name="specialization" type="text"
                                          class="mt-1 block w-full"
                                          :value="old('specialization', $user->doctorProfile->specialization ?? '')" />
                            <x-input-error class="mt-2" :messages="$errors->get('specialization')" />
                        </div>

                        <div>
                            <x-input-label for="consultation_fee" :value="__('messages.consultation_fee')" />
                            <x-text-input id="consultation_fee" name="consultation_fee" type="number" step="0.01" min="0"
                                          class="mt-1 block w-full"
                                          :value="old('consultation_fee', $user->doctorProfile->consultation_fee ?? '')" />
                            <x-input-error class="mt-2" :messages="$errors->get('consultation_fee')" />
                        </div>
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

        <!-- Save button (prominent, full-width on mobile) -->
        <div class="pt-6 border-t border-gray-200 dark:border-gray-700 flex items-center gap-4">
            <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-brand-600 to-brand-700 hover:from-brand-700 hover:to-brand-800 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ __('messages.save') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }"
                   x-show="show"
                   x-transition
                   x-init="setTimeout(() => show = false, 3000)"
                   class="text-sm font-medium text-green-600 dark:text-green-400 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/></svg>
                    {{ __('messages.saved') }}
                </p>
            @endif

            @if (session('status') === 'photo-deleted')
                <p x-data="{ show: true }"
                   x-show="show"
                   x-transition
                   x-init="setTimeout(() => show = false, 3000)"
                   class="text-sm font-medium text-green-600 dark:text-green-400">
                    {{ __('messages.photo_deleted') }}
                </p>
            @endif
        </div>
    </form>

    <!-- Hidden form for deleting photo (placed OUTSIDE the main form to avoid nesting) -->
    @if($user->profile_photo)
        <form id="delete-photo-form" method="POST" action="{{ route('profile.photo.delete') }}" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endif
</section>