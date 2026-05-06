<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('messages.doctor_profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Doctor info card -->
            <div class="bg-white dark:bg-gray-800 shadow-soft hover:shadow-medium transition-shadow sm:rounded-xl p-6">
                <div class="flex items-start gap-6">
                    @if($doctor->profile_photo_url)
                        <img src="{{ $doctor->profile_photo_url }}" alt="Photo" class="w-24 h-24 rounded-full object-cover">
                    @else
                        <div class="w-24 h-24 rounded-full bg-brand-100 dark:bg-brand-900/40 flex items-center justify-center text-brand-600 dark:text-brand-300 text-3xl font-bold">
                            {{ strtoupper(substr($doctor->first_name, 0, 1) . substr($doctor->last_name, 0, 1)) }}
                        </div>
                    @endif

                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Dr. {{ $doctor->full_name }}</h2>
                        <p class="text-brand-600 dark:text-brand-400">{{ $doctor->doctorProfile->specialization ?? 'General' }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $doctor->email }}</p>
                        @if($doctor->phone)
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $doctor->phone }}</p>
                        @endif

                        <!-- Rating -->
                        <div class="mt-3 flex items-center gap-2">
                            <x-star-rating :stars="$doctor->average_rating" size="md" />
                            @if($doctor->ratings_count > 0)
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $doctor->average_rating }} ({{ $doctor->ratings_count }} {{ $doctor->ratings_count === 1 ? __('messages.review') : __('messages.reviews') }})
                                </span>
                            @else
                                <span class="text-sm text-gray-400 dark:text-gray-500 italic">
                                    {{ __('messages.no_ratings_yet') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="text-right">
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('messages.consultation_fee') }}</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ number_format($doctor->doctorProfile->consultation_fee ?? 0, 2) }} MAD</p>
                    </div>
                </div>

                @if($doctor->doctorProfile && $doctor->doctorProfile->biography)
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('messages.about') }}</h3>
                        <p class="text-gray-700 dark:text-gray-300">{{ $doctor->doctorProfile->biography }}</p>
                    </div>
                @endif

                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 flex gap-3">
                    <a href="{{ route('patient.appointments.create', ['doctor' => $doctor->id]) }}"
                       class="px-5 py-2 bg-brand-600 text-white rounded-md hover:bg-brand-700 transition shadow-sm hover:shadow font-medium">
                        {{ __('messages.book_appointment') }}
                    </a>
                    <a href="{{ route('messages.start', $doctor) }}"
                       class="px-5 py-2 bg-white dark:bg-gray-700 border-2 border-brand-600 text-brand-600 dark:text-brand-400 rounded-md hover:bg-brand-50 dark:hover:bg-gray-600 transition font-medium">
                        {{ __('messages.message_doctor') }}
                    </a>
                    <a href="{{ route('patient.doctors.index') }}"
                       class="px-5 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition font-medium">
                        {{ __('messages.back_to_doctors') }}
                    </a>
                </div>
            </div>

            <!-- Reviews section -->
            @if($doctor->ratingsReceived->isNotEmpty())
                <div class="bg-white dark:bg-gray-800 shadow-soft hover:shadow-medium transition-shadow sm:rounded-xl p-6">
                    <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('messages.reviews') }} ({{ $doctor->ratingsReceived->count() }})
                    </h3>

                    <div class="space-y-4">
                        @foreach($doctor->ratingsReceived->sortByDesc('created_at') as $rating)
                            <div class="border-b border-gray-200 dark:border-gray-700 last:border-0 pb-4 last:pb-0">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-brand-100 dark:bg-brand-900/40 flex items-center justify-center text-brand-600 dark:text-brand-300 font-bold text-xs">
                                            {{ strtoupper(substr($rating->patient->first_name, 0, 1) . substr($rating->patient->last_name, 0, 1)) }}
                                        </div>
                                        <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $rating->patient->full_name }}
                                        </span>
                                    </div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $rating->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <x-star-rating :stars="$rating->stars" size="sm" />
                                @if($rating->comment)
                                    <p class="text-sm text-gray-700 dark:text-gray-300 mt-2 italic">
                                        "{{ $rating->comment }}"
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>