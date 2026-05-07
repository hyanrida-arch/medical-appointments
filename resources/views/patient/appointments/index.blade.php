<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('messages.my_appointments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Filter tabs + Export PDF -->
            <div class="bg-white dark:bg-gray-800 shadow-soft hover:shadow-medium transition-shadow sm:rounded-xl p-6 mb-6">
                <div class="flex gap-2 justify-between items-center flex-wrap">
                    <div class="flex gap-2">
                        <a href="{{ route('patient.appointments.index') }}"
                           class="px-4 py-2 rounded-md text-sm font-medium transition {{ !request('filter') ? 'bg-brand-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                            {{ __('messages.all') }}
                        </a>
                        <a href="{{ route('patient.appointments.index', ['filter' => 'upcoming']) }}"
                           class="px-4 py-2 rounded-md text-sm font-medium transition {{ request('filter') === 'upcoming' ? 'bg-brand-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                            {{ __('messages.upcoming') }}
                        </a>
                        <a href="{{ route('patient.appointments.index', ['filter' => 'past']) }}"
                           class="px-4 py-2 rounded-md text-sm font-medium transition {{ request('filter') === 'past' ? 'bg-brand-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                            {{ __('messages.past') }}
                        </a>
                    </div>

                    <a href="{{ route('patient.appointments.export-pdf') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition shadow-sm hover:shadow text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export PDF
                    </a>
                </div>
            </div>

            <!-- Appointments list -->
            @if($appointments->isEmpty())
                <div class="bg-white dark:bg-gray-800 shadow-soft hover:shadow-medium transition-shadow sm:rounded-xl p-6">
                    <p class="text-gray-500 dark:text-gray-400">
                        {{ __('messages.no_appointments_found') }}
                        <a href="{{ route('patient.doctors.index') }}" class="text-brand-600 dark:text-brand-400 hover:text-brand-900 dark:hover:text-brand-300">
                            {{ __('messages.find_a_doctor_arrow') }} &rarr;
                        </a>
                    </p>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 shadow-soft hover:shadow-medium transition-shadow sm:rounded-xl divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($appointments as $appointment)
                        <div class="p-6">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h3 class="font-medium text-gray-900 dark:text-gray-100">
                                        Dr. {{ $appointment->doctor->full_name }}
                                    </h3>
                                    <p class="text-sm text-brand-600 dark:text-brand-400">
                                        {{ $appointment->doctor->doctorProfile->specialization ?? 'General' }}
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        {{ $appointment->appointment_date->format('d M Y, H:i') }}
                                    </p>
                                    @if($appointment->reason)
                                        <p class="text-sm text-gray-500 dark:text-gray-400 italic mt-2">
                                            "{{ $appointment->reason }}"
                                        </p>
                                    @endif
                                    @if($appointment->status === 'completed' && $appointment->consultation_notes)
                                        <div class="mt-3 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded">
                                            <p class="text-xs font-semibold text-green-800 dark:text-green-300 mb-1">
                                                {{ __('messages.doctors_notes') }}
                                            </p>
                                            <p class="text-sm text-green-900 dark:text-green-200">
                                                {{ $appointment->consultation_notes }}
                                            </p>
                                        </div>
                                    @endif
                                </div>

                                <div class="text-right ml-4">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($appointment->status === 'pending') bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300
                                        @elseif($appointment->status === 'accepted') bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300
                                        @elseif($appointment->status === 'completed') bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300
                                        @elseif($appointment->status === 'refused') bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300
                                        @else bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200
                                        @endif">
                                        {{ __('messages.' . $appointment->status) }}
                                    </span>

                                    @if(in_array($appointment->status, ['pending', 'accepted']))
                                        <form method="POST" action="{{ route('patient.appointments.cancel', $appointment) }}" class="mt-2">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" onclick="return confirm('Are you sure?')"
                                                class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 text-sm font-medium">
                                                {{ __('messages.cancel') }}
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            <!-- Rating section: only for completed appointments -->
                            @if($appointment->status === 'completed')
                                @php
                                    $existingRating = \App\Models\Rating::where('appointment_id', $appointment->id)->first();
                                @endphp

                                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                    @if($existingRating)
                                        <div class="flex items-center gap-3">
                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                                {{ __('messages.rated') }}:
                                            </span>
                                            <x-star-rating :stars="$existingRating->stars" size="sm" />
                                            @if($existingRating->comment)
                                                <span class="text-sm text-gray-600 dark:text-gray-400 italic">
                                                    "{{ $existingRating->comment }}"
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <div x-data="{ open: false, stars: 0 }">
                                            <button @click="open = !open"
                                                    class="text-sm text-brand-600 dark:text-brand-400 hover:text-brand-900 dark:hover:text-brand-300 font-medium">
                                                ⭐ {{ __('messages.rate_doctor') }}
                                            </button>

                                            <div x-show="open" x-transition class="mt-3 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                                <form method="POST" action="{{ route('patient.appointments.rate', $appointment) }}">
                                                    @csrf

                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                        {{ __('messages.your_rating') }}
                                                    </label>

                                                    <div class="flex gap-1 mb-3">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <button type="button"
                                                                    @click="stars = {{ $i }}"
                                                                    class="focus:outline-none">
                                                                <svg class="w-8 h-8 transition-colors"
                                                                     :class="stars >= {{ $i }} ? 'text-yellow-400 fill-current' : 'text-gray-300 dark:text-gray-600 fill-current'"
                                                                     viewBox="0 0 20 20">
                                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.539 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                                </svg>
                                                            </button>
                                                        @endfor
                                                    </div>

                                                    <input type="hidden" name="stars" :value="stars" required>

                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                        {{ __('messages.comment_optional') }}
                                                    </label>
                                                    <textarea name="comment" rows="2"
                                                              class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500 text-sm"></textarea>

                                                    <div class="mt-3 flex gap-2">
                                                        <button type="submit"
                                                                :disabled="stars === 0"
                                                                :class="stars === 0 ? 'opacity-50 cursor-not-allowed' : ''"
                                                                class="px-4 py-2 bg-brand-600 text-white rounded-md hover:bg-brand-700 transition text-sm font-medium">
                                                            {{ __('messages.submit_rating') }}
                                                        </button>
                                                        <button type="button" @click="open = false"
                                                                class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition text-sm font-medium">
                                                            {{ __('messages.cancel') }}
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $appointments->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>