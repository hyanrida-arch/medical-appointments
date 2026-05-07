<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('messages.dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Welcome banner -->
            <div class="bg-white dark:bg-gray-800 shadow-soft hover:shadow-medium transition-shadow sm:rounded-xl p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                    {{ __('messages.welcome_back') }}, Dr. {{ Auth::user()->full_name }}
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    {{ __('messages.overview_today') }}
                </p>

                <!-- Doctor's average rating -->
                @php
                    $avgRating = Auth::user()->average_rating;
                    $ratingsCount = Auth::user()->ratings_count;
                @endphp
                <div class="mt-3 flex items-center gap-2">
                    <x-star-rating :stars="$avgRating" size="md" />
                    @if($ratingsCount > 0)
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            {{ $avgRating }} ({{ $ratingsCount }} {{ $ratingsCount === 1 ? __('messages.review') : __('messages.reviews') }})
                        </span>
                    @else
                        <span class="text-sm text-gray-400 dark:text-gray-500 italic">
                            {{ __('messages.no_ratings_yet') }}
                        </span>
                    @endif
                </div>
            </div>

            <!-- Stats cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 shadow-soft hover:shadow-medium transition-shadow rounded-xl p-6">
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.pending') }}</p>
                    <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $pendingCount ?? 0 }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-soft hover:shadow-medium transition-shadow rounded-xl p-6">
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.accepted') }}</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2">{{ $acceptedCount ?? 0 }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-soft hover:shadow-medium transition-shadow rounded-xl p-6">
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.completed') }}</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ $completedCount ?? 0 }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-soft hover:shadow-medium transition-shadow rounded-xl p-6">
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.total') }}</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $totalCount ?? 0 }}</p>
                </div>
            </div>

            <!-- Today's appointments -->
            <div class="bg-white dark:bg-gray-800 shadow-soft hover:shadow-medium transition-shadow sm:rounded-xl p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                    {{ __('messages.todays_appointments') }}
                </h3>

                @if(isset($todayAppointments) && $todayAppointments->isNotEmpty())
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($todayAppointments as $appointment)
                            <div class="py-4 flex justify-between items-center">
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ $appointment->patient->full_name }}
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $appointment->appointment_date->format('H:i') }}
                                        @if($appointment->reason)
                                            — {{ $appointment->reason }}
                                        @endif
                                    </p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($appointment->status === 'pending') bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300
                                        @elseif($appointment->status === 'accepted') bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300
                                        @elseif($appointment->status === 'completed') bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300
                                        @else bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200
                                        @endif">
                                        {{ __('messages.' . $appointment->status) }}
                                    </span>
                                    <a href="{{ route('doctor.appointments.show', $appointment) }}" class="text-brand-600 dark:text-brand-400 hover:text-brand-900 dark:hover:text-brand-300 text-sm font-medium">
                                        {{ __('messages.view') }} &rarr;
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400">
                        {{ __('messages.no_appointments_today') }}
                    </p>
                @endif
            </div>

            <!-- Reviews received -->
            @if(Auth::user()->ratingsReceived->isNotEmpty())
                <div class="bg-white dark:bg-gray-800 shadow-soft hover:shadow-medium transition-shadow sm:rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('messages.reviews') }} ({{ Auth::user()->ratingsReceived->count() }})
                    </h3>

                    <div class="space-y-4">
                        @foreach(Auth::user()->ratingsReceived->sortByDesc('created_at')->take(10) as $rating)
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