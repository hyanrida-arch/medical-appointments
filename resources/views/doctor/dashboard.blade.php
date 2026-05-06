
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('messages.dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome message -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-soft hover:shadow-medium transition-shadow sm:rounded-xl p-6 mb-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('messages.welcome_back') }}, Dr. {{ Auth::user()->full_name }}</h3>
                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('messages.overview_today') }}</p>
            </div>

            <!-- Stats grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.pending_requests') }}</div>
                    <div class="text-3xl font-bold text-yellow-600 mt-2">{{ $stats['pending'] }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <div class="text-sm text-gray-600 dark:text-gray-400">Accepted</div>
                    <div class="text-3xl font-bold text-blue-600 mt-2">{{ $stats['accepted'] }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.completed') }}</div>
                    <div class="text-3xl font-bold text-green-600 mt-2">{{ $stats['completed'] }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.total_appointments') }}</div>
                    <div class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $stats['total'] }}</div>
                </div>
            </div>

            <!-- Today's appointments -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-soft hover:shadow-medium transition-shadow sm:rounded-xl">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.todays_appointments') }}</h3>

                    @if($todayAppointments->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400">No appointments scheduled for today.</p>
                    @else
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($todayAppointments as $appointment)
                                <div class="py-4 flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-gray-100">{{ $appointment->patient->full_name }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $appointment->appointment_date->format('H:i') }}</p>
                                        @if($appointment->reason)
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $appointment->reason }}</p>
                                        @endif
                                    </div>
                                    <span class="px-3 py-1 text-xs rounded-full
                                        @if($appointment->status === 'pending') bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300
                                        @elseif($appointment->status === 'accepted') bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300
                                        @endif">
                                        {{ __('messages.' . $appointment->status) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
