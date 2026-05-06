<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Appointment Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <x-flash-messages />

            <div class="bg-white dark:bg-gray-800 shadow-soft hover:shadow-medium transition-shadow sm:rounded-xl p-6 mb-6">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $appointment->patient->full_name }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $appointment->patient->email }}</p>
                        @if($appointment->patient->phone)
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $appointment->patient->phone }}</p>
                        @endif
                    </div>
                    <span class="px-3 py-1 text-sm rounded-full
                        @if($appointment->status === 'pending') bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300
                        @elseif($appointment->status === 'accepted') bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300
                        @elseif($appointment->status === 'completed') bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300
                        @elseif($appointment->status === 'refused') bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300
                        @else bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100 @endif">
                        {{ ucfirst($appointment->status) }}
                    </span>
                </div>

                <div class="border-t dark:border-gray-700 pt-4 space-y-3">
                    <div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Date & Time:</span>
                        <span class="text-sm text-gray-900 dark:text-gray-100">{{ $appointment->appointment_date->format('d M Y, H:i') }}</span>
                    </div>
                    @if($appointment->reason)
                        <div>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Reason:</span>
                            <p class="text-sm text-gray-900 dark:text-gray-100 mt-1">{{ $appointment->reason }}</p>
                        </div>
                    @endif
                    @if($appointment->consultation_notes)
                        <div>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Consultation Notes:</span>
                            <p class="text-sm text-gray-900 dark:text-gray-100 mt-1 whitespace-pre-wrap">{{ $appointment->consultation_notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action buttons -->
            @if($appointment->status === 'pending')
                <div class="bg-white dark:bg-gray-800 shadow-soft hover:shadow-medium transition-shadow sm:rounded-xl p-6 flex gap-3">
                    <form method="POST" action="{{ route('doctor.appointments.accept', $appointment) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">{{ __('messages.accept') }}</button>
                    </form>
                    <form method="POST" action="{{ route('doctor.appointments.refuse', $appointment) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">{{ __('messages.refuse') }}</button>
                    </form>
                </div>
            @endif

            @if($appointment->status === 'accepted')
                <div class="bg-white dark:bg-gray-800 shadow-soft hover:shadow-medium transition-shadow sm:rounded-xl p-6">
                    <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.mark_completed') }}</h4>
                    <form method="POST" action="{{ route('doctor.appointments.complete', $appointment) }}">
                        @csrf
                        @method('PATCH')
                        <div class="mb-4">
                            <label for="consultation_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Consultation Notes (optional)</label>
                            <textarea id="consultation_notes" name="consultation_notes" rows="5" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm" placeholder="Diagnosis, prescriptions, follow-up instructions..."></textarea>
                            <x-input-error :messages="$errors->get('consultation_notes')" class="mt-2" />
                        </div>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">{{ __('messages.mark_completed') }}</button>
                    </form>
                </div>
            @endif

            <div class="mt-4">
                <a href="{{ route('doctor.appointments.index') }}" class="text-brand-600 hover:text-brand-900">&larr; Back to appointments</a>
            </div>
        </div>
    </div>
</x-app-layout>
