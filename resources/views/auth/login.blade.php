<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-white sm:bg-gray-50 p-4 sm:p-6">
        
        <div class="max-w-5xl w-full bg-white sm:rounded-[2rem] sm:shadow-2xl overflow-hidden flex flex-col md:flex-row min-h-[600px] border border-gray-100">
            
            <div class="hidden md:flex md:w-1/2 p-12 flex-col justify-center relative bg-gray-50/50 border-r border-gray-100">
                <div class="relative z-10 max-w-sm">
                    
                          <div class="flex items-center gap-3 mb-8">
                        <div class="bg-brand-500 p-3 rounded-2xl shadow-lg shadow-brand-200">
                            <x-application-logo class="w-8 h-8 text-white" />
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">MediCare+</h1>
                    </div>
                    
                    <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-4">Votre santé, notre priorité.</h2>
                    <p class="text-gray-500 leading-relaxed mb-8">Accédez à votre espace sécurisé pour consulter vos dossiers, prendre rendez-vous et contacter vos professionnels de santé.</p>
                    
                    <div class="flex items-center gap-4 text-sm font-bold text-gray-400">
                        <span class="flex items-center gap-1.5"><svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Simple</span>
                        <span class="flex items-center gap-1.5"><svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg> Sécurisé</span>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-1/2 p-8 lg:p-14 flex flex-col justify-center bg-white">
                <div class="max-w-md mx-auto w-full">

                    <div class="md:hidden flex justify-center mb-8">
                        <div class="md:hidden flex justify-center mb-8">
                        <div class="bg-brand-500 p-3 rounded-2xl shadow-lg shadow-brand-200">
                            <x-application-logo class="w-10 h-10 text-white" />
                        </div>
                    </div>
                    </div>

                    <header class="mb-10 text-center sm:text-left">
                        <h3 class="text-3xl font-black text-gray-900 mb-2">Log in</h3>
                        <p class="text-gray-500">Nouveau sur MediCare+ ? <a href="{{ route('register') }}" class="text-blue-600 font-bold hover:underline">S'inscrire</a></p>
                    </header>

                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf
                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                placeholder="votre@email.com"
                                class="w-full px-4 py-3.5 bg-white text-gray-700 border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 rounded-xl transition-all outline-none">
                            @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label class="block text-sm font-bold text-gray-700">Password</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-800 font-semibold transition-colors">
                                        Oublié ?
                                    </a>
                                @endif
                            </div>
                            <input type="password" name="password" required
                                placeholder="••••••••"
                                class="w-full px-4 py-3.5 bg-white text-gray-700 border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 rounded-xl transition-all outline-none">
                            @error('password') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="pt-2">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 w-4 h-4">
                                <span class="ms-2 text-sm text-gray-600 font-medium">Remember me</span>
                            </label>
                        </div>

                        <button type="submit" 
                                class="w-full mt-6 py-4 text-white font-bold rounded-xl transform transition hover:-translate-y-1 active:scale-95" 
                                style="background-color: #2563eb; box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3);">
                            Log in →
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>