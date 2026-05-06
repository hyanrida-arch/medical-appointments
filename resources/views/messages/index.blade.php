<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('messages.messages') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if($conversations->isEmpty())
                <div class="bg-white dark:bg-gray-800 shadow-soft hover:shadow-medium transition-shadow sm:rounded-xl p-6">
                    <p class="text-gray-500 dark:text-gray-400">
                        {{ __('messages.no_conversations_yet') }}
                        @if(Auth::user()->isPatient())
                            <a href="{{ route('patient.doctors.index') }}" class="text-brand-600 dark:text-brand-400 hover:text-brand-900 dark:hover:text-brand-300">
                                {{ __('messages.find_doctor_to_chat') }} &rarr;
                            </a>
                        @endif
                    </p>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 shadow-soft sm:rounded-xl overflow-hidden divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($conversations as $conversation)
                        @php
                            $other = Auth::user()->isPatient() ? $conversation->doctor : $conversation->patient;
                            $unreadCount = $conversation->messages()
                                ->where('sender_id', '!=', Auth::id())
                                ->whereNull('read_at')
                                ->count();
                        @endphp

                        <div class="flex items-center justify-between p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors {{ $unreadCount > 0 ? 'bg-brand-50 dark:bg-brand-900/10' : '' }}">
                            <a href="{{ route('messages.show', $conversation) }}" class="flex items-center flex-1 min-w-0">
                                @if($other->profile_photo_url)
                                    <img src="{{ $other->profile_photo_url }}" alt="" class="w-12 h-12 rounded-full object-cover flex-shrink-0">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-brand-100 dark:bg-brand-900/40 flex items-center justify-center text-brand-600 dark:text-brand-300 font-bold flex-shrink-0">
                                        {{ strtoupper(substr($other->first_name, 0, 1) . substr($other->last_name, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="ml-4 flex-1 min-w-0">
                                    <div class="flex justify-between items-baseline">
                                        <h3 class="font-medium text-gray-900 dark:text-gray-100 truncate">
                                            @if($other->isDoctor())
                                                Dr.
                                            @endif
                                            {{ $other->full_name }}
                                        </h3>
                                        @if($conversation->latestMessage)
                                            <span class="text-xs text-gray-500 dark:text-gray-400 ml-2 flex-shrink-0">
                                                {{ $conversation->latestMessage->created_at->diffForHumans() }}
                                            </span>
                                        @endif
                                    </div>
                                    @if($other->isDoctor() && $other->doctorProfile)
                                        <p class="text-sm text-brand-600 dark:text-brand-400 truncate">
                                            {{ $other->doctorProfile->specialization }}
                                        </p>
                                    @endif
                                    @if($conversation->latestMessage)
                                        <p class="text-sm text-gray-600 dark:text-gray-400 truncate mt-1">
                                            @if($conversation->latestMessage->sender_id === Auth::id())
                                                <span class="text-gray-500 dark:text-gray-500">{{ __('messages.you') }}:</span>
                                            @endif
                                            {{ $conversation->latestMessage->body }}
                                        </p>
                                    @endif
                                </div>
                            </a>

                            <div class="flex items-center gap-3 ml-3 flex-shrink-0">
                                @if($unreadCount > 0)
                                    <span class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-brand-600 rounded-full">
                                        {{ $unreadCount }}
                                    </span>
                                @endif

                                <!-- Delete button -->
                                <form method="POST" action="{{ route('messages.destroy', $conversation) }}"
                                      onsubmit="return confirm('{{ __('messages.confirm_delete_conversation') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="p-2 text-gray-400 hover:text-red-600 dark:text-gray-500 dark:hover:text-red-400 transition-colors"
                                            title="{{ __('messages.delete_conversation') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>