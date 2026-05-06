@props(['stars' => 0, 'size' => 'md', 'showCount' => false, 'count' => 0])

@php
    $sizeClass = match($size) {
        'sm' => 'w-4 h-4',
        'lg' => 'w-7 h-7',
        default => 'w-5 h-5',
    };
    $textSize = match($size) {
        'sm' => 'text-xs',
        'lg' => 'text-base',
        default => 'text-sm',
    };
    $rounded = round($stars * 2) / 2; // arrondi à 0.5 près
@endphp

<div class="inline-flex items-center gap-1">
    @for($i = 1; $i <= 5; $i++)
        @if($i <= $rounded)
            {{-- Étoile pleine --}}
            <svg class="{{ $sizeClass }} text-yellow-400 fill-current" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.539 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
        @elseif($i - 0.5 == $rounded)
            {{-- Demi-étoile --}}
            <svg class="{{ $sizeClass }} text-yellow-400" viewBox="0 0 20 20">
                <defs>
                    <linearGradient id="half-{{ $i }}-{{ rand() }}">
                        <stop offset="50%" stop-color="currentColor"/>
                        <stop offset="50%" stop-color="#d1d5db"/>
                    </linearGradient>
                </defs>
                <path fill="url(#half-{{ $i }})" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.539 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
        @else
            {{-- Étoile vide --}}
            <svg class="{{ $sizeClass }} text-gray-300 dark:text-gray-600 fill-current" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.539 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
        @endif
    @endfor

    @if($showCount)
        <span class="{{ $textSize }} text-gray-600 dark:text-gray-400 ml-1">
            @if($stars > 0)
                {{ $stars }}
                @if($count > 0)
                    ({{ $count }})
                @endif
            @else
                <span class="italic">{{ __('messages.no_ratings_yet') }}</span>
            @endif
        </span>
    @endif
</div>