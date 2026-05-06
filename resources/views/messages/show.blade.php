<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            @php
                $other = Auth::user()->isPatient() ? $conversation->doctor : $conversation->patient;
            @endphp
            @if($other->isDoctor())Dr. @endif{{ $other->full_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4">
                <a href="{{ route('messages.index') }}" class="text-brand-600 dark:text-brand-400 hover:text-brand-900 dark:hover:text-brand-300 text-sm font-medium">
                    &larr; {{ __('messages.back_to_messages') }}
                </a>
            </div>

            <!-- Messages thread -->
            <div class="bg-white dark:bg-gray-800 shadow-soft sm:rounded-xl p-6 mb-4 max-h-[500px] overflow-y-auto">
                @if($conversation->messages->isEmpty())
                    <p class="text-center text-gray-500 dark:text-gray-400 py-8">
                        {{ __('messages.no_messages_yet') }}
                    </p>
                @else
                    <div class="space-y-4">
                        @foreach($conversation->messages as $message)
                            @php $isMine = $message->sender_id === Auth::id(); @endphp
                            <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-xs md:max-w-md px-4 py-2 rounded-2xl
                                    {{ $isMine
                                        ? 'bg-brand-600 text-white rounded-br-sm'
                                        : 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-bl-sm' }}">
                                    <p class="text-sm whitespace-pre-wrap break-words">{{ $message->body }}</p>
                                    <p class="text-xs mt-1 {{ $isMine ? 'text-brand-100' : 'text-gray-500 dark:text-gray-400' }}">
                                        {{ $message->created_at->format('H:i') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Reply form -->
            <div class="bg-white dark:bg-gray-800 shadow-soft sm:rounded-xl p-4">
                <form method="POST" action="{{ route('messages.store', $conversation) }}">
                    @csrf
                    <textarea name="body" rows="3" required
                        placeholder="{{ __('messages.type_your_message') }}"
                        class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500"></textarea>
                    @error('body')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                    <div class="flex justify-end mt-3">
                        <button type="submit" class="px-5 py-2 bg-brand-600 text-white rounded-md hover:bg-brand-700 transition shadow-sm hover:shadow font-medium">
                            {{ __('messages.send') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>