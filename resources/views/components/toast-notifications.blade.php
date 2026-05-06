@php
    $messages = [];
    if (session('success')) {
        $messages[] = ['type' => 'success', 'text' => session('success')];
    }
    if (session('error')) {
        $messages[] = ['type' => 'error', 'text' => session('error')];
    }
    if (session('status') === 'profile-updated') {
        $messages[] = ['type' => 'success', 'text' => __('Profile updated.')];
    }
    if (session('status') === 'password-updated') {
        $messages[] = ['type' => 'success', 'text' => __('Password updated.')];
    }
@endphp

@if(count($messages) > 0)
    <div
        x-data="{
            toasts: @js($messages),
            remove(index) { this.toasts.splice(index, 1); }
        }"
        x-init="setTimeout(() => toasts = [], 4500)"
        class="fixed top-6 right-6 z-50 space-y-3 max-w-sm w-full pointer-events-none"
    >
        <template x-for="(toast, index) in toasts" :key="index">
            <div
                x-show="true"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="transform translate-x-full opacity-0"
                x-transition:enter-end="transform translate-x-0 opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="pointer-events-auto rounded-xl shadow-hover overflow-hidden flex items-start gap-3 p-4 border"
                :class="{
                    'bg-health-50 border-health-200': toast.type === 'success',
                    'bg-red-50 border-red-200': toast.type === 'error'
                }"
            >
                <!-- Icon -->
                <div class="flex-shrink-0">
                    <template x-if="toast.type === 'success'">
                        <svg class="w-6 h-6 text-health-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </template>
                    <template x-if="toast.type === 'error'">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </template>
                </div>

                <!-- Message -->
                <div class="flex-1 text-sm font-medium" :class="{
                    'text-health-800': toast.type === 'success',
                    'text-red-800': toast.type === 'error'
                }">
                    <span x-text="toast.text"></span>
                </div>

                <!-- Close button -->
                <button @click="remove(index)" class="flex-shrink-0 text-gray-400 hover:text-gray-600 dark:text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </template>
    </div>
@endif
