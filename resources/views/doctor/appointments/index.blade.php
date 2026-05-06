
<x-app-layout>
    <x-slot name="header">
       <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('messages.appointments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-flash-messages />

            <!-- Filters -->
            <div class="bg-white dark:bg-gray-800 shadow-soft hover:shadow-medium transition-shadow sm:rounded-xl p-6 mb-6">
                <form method="GET" action="{{ route('doctor.appointments.index') }}" class="flex flex-wrap gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.status') }}</label>
                        <select name="status" class="mt-1 border-gray-300 dark:border-gray-600 rounded-md shadow-sm">
                            <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>{{ __('messages.all') }}</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>{{ __('messages.pending') }}</option>
                            <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Accepted</option>
                            <option value="refused" {{ request('status') === 'refused' ? 'selected' : '' }}>Refused</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>{{ __('messages.completed') }}</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.date') }}</label>
                        <input type="date" name="date" value="{{ request('date') }}" class="mt-1 border-gray-300 dark:border-gray-600 rounded-md shadow-sm">
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="px-4 py-2 bg-brand-600 text-white rounded-md hover:bg-brand-700 transition shadow-sm hover:shadow">{{ __('messages.filter') }}</button>
                        <a href="{{ route('doctor.appointments.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-300">{{ __('messages.reset') }}</a>
                    </div>
                </form>
            </div>

            <!-- Appointments list -->
            <div class="bg-white dark:bg-gray-800 shadow-soft hover:shadow-medium transition-shadow sm:rounded-xl overflow-hidden">
                @if($appointments->isEmpty())
                    <p class="p-6 text-gray-500 dark:text-gray-400">No appointments found.</p>
                @else
                    <table class="min-w-full dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ __('messages.patient_label') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Date & Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ __('messages.status') }}</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ __('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($appointments as $appointment)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900 dark:text-gray-100">{{ $appointment->patient->full_name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $appointment->patient->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                        {{ $appointment->appointment_date->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 text-xs rounded-full
                                            @if($appointment->status === 'pending') bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300
                                            @elseif($appointment->status === 'accepted') bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300
                                            @elseif($appointment->status === 'completed') bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300
                                            @elseif($appointment->status === 'refused') bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300
                                            @else bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100 @endif">
                                           {{ __('messages.' . $appointment->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm">
                                        <a href="{{ route('doctor.appointments.show', $appointment) }}" class="text-brand-600 hover:text-brand-900">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="p-6">
                        {{ $appointments->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
