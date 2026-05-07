<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('messages.book_appointment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-soft hover:shadow-medium transition-shadow sm:rounded-xl p-6">

                <form method="POST" action="{{ route('patient.appointments.store') }}" class="space-y-5">
                    @csrf

                    <!-- Doctor selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('messages.doctor') }}
                        </label>
                        <select name="doctor_id" required
                            class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500">
                            <option value="">-- {{ __('messages.select_role') }} --</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}" {{ (string) $preselectedDoctorId === (string) $doctor->id ? 'selected' : '' }}>
                                    Dr. {{ $doctor->full_name }}
                                    @if($doctor->doctorProfile && $doctor->doctorProfile->specialization)
                                        ({{ $doctor->doctorProfile->specialization }})
                                    @endif
                                    @if($doctor->doctorProfile && $doctor->doctorProfile->consultation_fee)
                                        — {{ number_format($doctor->doctorProfile->consultation_fee, 2) }} MAD
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('doctor_id')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date and Time -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('messages.date_and_time') }}
                        </label>
                        <input type="datetime-local" name="appointment_date" required
                            min="{{ now()->format('Y-m-d\TH:i') }}"
                            value="{{ old('appointment_date') }}"
                            class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500">
                        @error('appointment_date')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Reason -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('messages.reason_for_visit') }}
                        </label>
                        <textarea name="reason" rows="4"
                            placeholder="{{ __('messages.reason_placeholder') }}"
                            class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500">{{ old('reason') }}</textarea>
                        @error('reason')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Info -->
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded p-3">
                        <p class="text-sm text-blue-800 dark:text-blue-300">
                            {{ __('messages.request_sent_info') }}
                        </p>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3">
                        <button type="submit" class="px-5 py-2 bg-brand-600 text-white rounded-md hover:bg-brand-700 transition shadow-sm hover:shadow font-medium">
                            {{ __('messages.send_request') }}
                        </button>
                        <a href="{{ route('patient.doctors.index') }}" class="px-5 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition font-medium">
                            {{ __('messages.cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>