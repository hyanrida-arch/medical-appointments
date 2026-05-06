<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Book Appointment
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-soft hover:shadow-medium transition-shadow sm:rounded-xl p-6">
                <!-- Doctor info summary -->
                <div class="flex items-center mb-6 pb-4 border-b">
@if($doctor->profile_photo_url)
    <img src="{{ $doctor->profile_photo_url }}" alt="Photo" class="w-12 h-12 rounded-full object-cover">
@else
    <div class="w-12 h-12 rounded-full bg-brand-100 dark:bg-brand-900/40 flex items-center justify-center text-brand-600 dark:text-brand-300 font-bold">
        {{ strtoupper(substr($doctor->first_name, 0, 1) . substr($doctor->last_name, 0, 1)) }}
    </div>
@endif
                    <div class="ml-4">
                        <h3 class="font-medium text-gray-900 dark:text-gray-100">Dr. {{ $doctor->full_name }}</h3>
                        <p class="text-sm text-brand-600">{{ $doctor->doctorProfile->specialization ?? 'General' }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ number_format($doctor->doctorProfile->consultation_fee ?? 0, 2) }} MAD</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('patient.appointments.store') }}">
                    @csrf
                    <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">

                    <div class="mb-4">
                        <label for="appointment_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date and Time</label>
                        <input type="datetime-local" id="appointment_date" name="appointment_date"
                            value="{{ old('appointment_date') }}"
                            min="{{ now()->format('Y-m-d\TH:i') }}"
                            required
                            class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500">
                        <x-input-error :messages="$errors->get('appointment_date')" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <label for="reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reason for visit (optional)</label>
                        <textarea id="reason" name="reason" rows="4"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500"
                            placeholder="Briefly describe your symptoms or reason for the appointment...">{{ old('reason') }}</textarea>
                        <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="px-6 py-2 bg-brand-600 text-white rounded-md hover:bg-brand-700 transition shadow-sm hover:shadow">
                            Send Request
                        </button>
                        <a href="{{ route('patient.doctors.show', $doctor) }}"
                           class="px-6 py-2 bg-gray-200 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-300">
                            Cancel
                        </a>
                    </div>
                </form>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-4">
                    Your request will be sent to the doctor. They will review and confirm or decline.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
