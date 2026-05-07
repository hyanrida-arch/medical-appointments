<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Left Side -->
            <div class="flex">

                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
               <div class="hidden sm:flex sm:items-center sm:ms-10 gap-4 lg:gap-6">
                    @auth

                        @if(Auth::user()->isDoctor())
                            <x-nav-link :href="route('doctor.dashboard')" :active="request()->routeIs('doctor.dashboard')">
                                {{ __('messages.dashboard') }}
                            </x-nav-link>

                            <x-nav-link :href="route('doctor.appointments.index')" :active="request()->routeIs('doctor.appointments.*')">
                                {{ __('messages.appointments') }}
                            </x-nav-link>

                        @elseif(Auth::user()->isPatient())

                            <x-nav-link :href="route('patient.dashboard')" :active="request()->routeIs('patient.dashboard')">
                                {{ __('messages.dashboard') }}
                            </x-nav-link>

                            <x-nav-link :href="route('patient.doctors.index')" :active="request()->routeIs('patient.doctors.*')">
                                {{ __('messages.find_a_doctor') }}
                            </x-nav-link>

                            <x-nav-link :href="route('patient.appointments.index')" :active="request()->routeIs('patient.appointments.*')">
                                {{ __('messages.my_appointments') }}
                            </x-nav-link>

                        @endif

                        <x-nav-link :href="route('messages.index')" :active="request()->routeIs('messages.*')">
                            {{ __('messages.messages') }}
                        </x-nav-link>

                    @endauth
                </div>
            </div>

            <!-- Right Side -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-3">

                <!-- Language Switcher -->
                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-300 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-white focus:outline-none transition">
                            
                            {{ strtoupper(app()->getLocale()) }}

                            <svg class="ms-1 h-4 w-4"
                                 xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20"
                                 fill="currentColor">

                                <path fill-rule="evenodd"
                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                      clip-rule="evenodd" />
                            </svg>

                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('locale.switch', 'en')">
                            🇬🇧 English
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('locale.switch', 'fr')">
                            🇫🇷 Français
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('locale.switch', 'ar')">
                            🇲🇦 العربية
                        </x-dropdown-link>
                    </x-slot>

                </x-dropdown>

                <!-- Dark Mode Toggle -->
                <button onclick="toggleDarkMode()"
                        class="p-2 rounded-md text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white focus:outline-none transition">

                    <!-- Sun -->
                    <svg id="sun-icon"
                         class="w-5 h-5 hidden dark:block"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>

                    <!-- Moon -->
                    <svg id="moon-icon"
                         class="w-5 h-5 block dark:hidden"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>

                </button>

                <!-- User Dropdown -->
                @auth

                <x-dropdown align="right" width="56">

                    <x-slot name="trigger">

                        <button class="inline-flex items-center px-3 py-2 border border-transparent rounded-xl bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition focus:outline-none">

                            <div class="flex items-center gap-3">

                                @if(Auth::user()->profile_photo_url)

                                    <img 
                                        src="{{ Auth::user()->profile_photo_url }}"
                                        alt="Profile Photo"
                                        class="w-10 h-10 rounded-full object-cover border border-gray-300 dark:border-gray-600 shadow-sm"
                                    >

                                @endif

                                <div class="flex flex-col items-start leading-tight">

                                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                                        {{ Auth::user()->full_name }}
                                    </span>

                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ __('messages.profile') }}
                                    </span>

                                </div>

                                <svg class="ms-2 h-4 w-4 text-gray-500 dark:text-gray-400"
                                     xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20"
                                     fill="currentColor">

                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd" />
                                </svg>

                            </div>

                        </button>

                    </x-slot>

                    <x-slot name="content">

                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('messages.profile') }}
                        </x-dropdown-link>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault(); this.closest('form').submit();">

                                {{ __('messages.log_out') }}

                            </x-dropdown-link>
                        </form>

                    </x-slot>

                </x-dropdown>

                @endauth

            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">

                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 transition duration-150 ease-in-out">

                    <svg class="h-6 w-6"
                         stroke="currentColor"
                         fill="none"
                         viewBox="0 0 24 24">

                        <path :class="{'hidden': open, 'inline-flex': ! open }"
                              class="inline-flex"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />

                        <path :class="{'hidden': ! open, 'inline-flex': open }"
                              class="hidden"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />

                    </svg>

                </button>

            </div>
        </div>
    </div>

    <!-- Responsive Navigation -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">

        <div class="pt-2 pb-3 space-y-1">

            @auth

                @if(Auth::user()->isDoctor())

                    <x-responsive-nav-link :href="route('doctor.dashboard')" :active="request()->routeIs('doctor.dashboard')">
                        {{ __('messages.dashboard') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('doctor.appointments.index')" :active="request()->routeIs('doctor.appointments.*')">
                        {{ __('messages.appointments') }}
                    </x-responsive-nav-link>

                @elseif(Auth::user()->isPatient())

                    <x-responsive-nav-link :href="route('patient.dashboard')" :active="request()->routeIs('patient.dashboard')">
                        {{ __('messages.dashboard') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('patient.doctors.index')" :active="request()->routeIs('patient.doctors.*')">
                        {{ __('messages.find_a_doctor') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('patient.appointments.index')" :active="request()->routeIs('patient.appointments.*')">
                        {{ __('messages.my_appointments') }}
                    </x-responsive-nav-link>

                @endif

                <x-responsive-nav-link :href="route('messages.index')" :active="request()->routeIs('messages.*')">
                    {{ __('messages.messages') }}
                </x-responsive-nav-link>

            @endauth

        </div>

        <!-- Mobile Settings -->
        @auth

        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-700">

            <div class="px-4">

                <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                    {{ Auth::user()->full_name }}
                </div>

                <div class="font-medium text-sm text-gray-500 dark:text-gray-400">
                    {{ Auth::user()->email }}
                </div>

            </div>

            <div class="mt-3 space-y-1">

                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('messages.profile') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('locale.switch', 'en')">
                    🇬🇧 English
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('locale.switch', 'fr')">
                    🇫🇷 Français
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('locale.switch', 'ar')">
                    🇲🇦 العربية
                </x-responsive-nav-link>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                                           onclick="event.preventDefault(); this.closest('form').submit();">

                        {{ __('messages.log_out') }}

                    </x-responsive-nav-link>
                </form>

            </div>
        </div>

        @endauth
    </div>
</nav>

<script>
    function toggleDarkMode() {
        const html = document.documentElement;
        const isDark = html.classList.toggle('dark');

        localStorage.setItem('darkMode', isDark);
    }
</script>