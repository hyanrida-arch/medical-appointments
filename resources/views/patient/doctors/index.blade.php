<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('messages.find_a_doctor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filters card -->
            <div class="bg-white dark:bg-gray-800 shadow-soft hover:shadow-medium transition-shadow sm:rounded-xl p-6 mb-6">
                <form method="GET" action="{{ route('patient.doctors.index') }}" class="space-y-4">
                    <!-- Search bar -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.search') }}</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="{{ __('messages.search_placeholder') }}"
                            class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500">
                    </div>

                    <!-- Filter row -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Specialization -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.specialization') }}</label>
                            <select name="specialization" class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500">
                                <option value="">{{ __('messages.all') }}</option>
                                @foreach($specializations as $spec)
                                    <option value="{{ $spec }}" {{ request('specialization') === $spec ? 'selected' : '' }}>{{ $spec }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Min price -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.min_price') }}</label>
                            <input type="number" name="min_price" value="{{ request('min_price') }}" min="0" step="50"
                                class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500">
                        </div>

                        <!-- Max price -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.max_price') }}</label>
                            <input type="number" name="max_price" value="{{ request('max_price') }}" min="0" step="50"
                                class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500">
                        </div>

                        <!-- Sort -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.sort_by') }}</label>
                            <select name="sort" class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500">
                                <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>{{ __('messages.name_asc') }}</option>
                                <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>{{ __('messages.name_desc') }}</option>
                                <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>{{ __('messages.price_asc') }}</option>
                                <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>{{ __('messages.price_desc') }}</option>
                                <option value="top_rated" {{ request('sort') === 'top_rated' ? 'selected' : '' }}>{{ __('messages.top_rated') }} ⭐</option>
                            </select>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3 pt-2">
                        <button type="submit" class="px-5 py-2 bg-brand-600 text-white rounded-md hover:bg-brand-700 transition shadow-sm hover:shadow font-medium">
                            {{ __('messages.apply_filters') }}
                        </button>
                        @if(request()->hasAny(['search', 'specialization', 'min_price', 'max_price', 'sort']))
                            <a href="{{ route('patient.doctors.index') }}" class="px-5 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition font-medium">
                                {{ __('messages.reset') }}
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Result count -->
            <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                {{ $doctors->total() }} {{ Str::plural('doctor', $doctors->total()) }} found
            </div>

            <!-- Doctors grid -->
            @if($doctors->isEmpty())
                <div class="bg-white dark:bg-gray-800 shadow-soft hover:shadow-medium transition-shadow sm:rounded-xl p-6">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('messages.no_doctors_match') }}</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($doctors as $doctor)
                        <div class="bg-white dark:bg-gray-800 shadow-soft hover:shadow-hover hover:-translate-y-1 transition-all duration-200 rounded-xl p-6 flex flex-col">
                            <div class="flex items-center mb-4">
                                @if($doctor->profile_photo_url)
                                    <img src="{{ $doctor->profile_photo_url }}" alt="Photo" class="w-16 h-16 rounded-full object-cover">
                                @else
                                    <div class="w-16 h-16 rounded-full bg-brand-100 dark:bg-brand-900/40 flex items-center justify-center text-brand-600 dark:text-brand-300 text-xl font-bold">
                                        {{ strtoupper(substr($doctor->first_name, 0, 1) . substr($doctor->last_name, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="ml-4">
                                    <h3 class="font-medium text-gray-900 dark:text-gray-100">Dr. {{ $doctor->full_name }}</h3>
                                    <p class="text-sm text-brand-600 dark:text-brand-400">{{ $doctor->doctorProfile->specialization ?? 'General' }}</p>
                                </div>
                            </div>

                            @if($doctor->doctorProfile && $doctor->doctorProfile->biography)
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">{{ $doctor->doctorProfile->biography }}</p>
                            @endif

                            <!-- Rating display -->
                            <div class="mb-3 flex items-center gap-2">
                                <x-star-rating :stars="$doctor->average_rating" size="sm" />
                                @if($doctor->ratings_count > 0)
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $doctor->average_rating }} ({{ $doctor->ratings_count }} {{ $doctor->ratings_count === 1 ? __('messages.review') : __('messages.reviews') }})
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400 dark:text-gray-500 italic">
                                        {{ __('messages.no_ratings_yet') }}
                                    </span>
                                @endif
                            </div>

                            <div class="mt-auto pt-4 flex items-center justify-between border-t border-gray-200 dark:border-gray-700">
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    {{ number_format($doctor->doctorProfile->consultation_fee ?? 0, 2) }} MAD
                                </span>
                                <a href="{{ route('patient.doctors.show', $doctor) }}" class="text-brand-600 dark:text-brand-400 hover:text-brand-900 dark:hover:text-brand-300 text-sm font-medium">
                                    {{ __('messages.view_profile') }} &rarr;
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $doctors->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>