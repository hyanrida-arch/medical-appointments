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
                        <div class="bg-brand-500 p-3 rounded-2xl shadow-lg shadow-brand-200">
                            <x-application-logo class="w-10 h-10 text-white" />
                        </div>
                    </div>

                    <header class="mb-10 text-center sm:text-left">
                        <h3 class="text-3xl font-black text-gray-900 mb-2">Register</h3>
                        <p class="text-gray-500">Déjà inscrit ? <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline">Se connecter</a></p>
                    </header>

                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">First Name</label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}" required
                                    class="w-full px-4 py-3.5 bg-white text-gray-700 border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 rounded-xl transition-all outline-none">
                                @error('first_name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Last Name</label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}" required
                                    class="w-full px-4 py-3.5 bg-white text-gray-700 border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 rounded-xl transition-all outline-none">
                                @error('last_name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                    class="w-full px-4 py-3.5 bg-white text-gray-700 border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 rounded-xl transition-all outline-none">
                                @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Phone (Optional)</label>
                                <input type="text" name="phone" value="{{ old('phone') }}"
                                    class="w-full px-4 py-3.5 bg-white text-gray-700 border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 rounded-xl transition-all outline-none">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Password</label>
                                <input type="password" name="password" required
                                    class="w-full px-4 py-3.5 bg-white text-gray-700 border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 rounded-xl transition-all outline-none">
                                @error('password') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Confirm Password</label>
                                <input type="password" name="password_confirmation" required
                                    class="w-full px-4 py-3.5 bg-white text-gray-700 border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 rounded-xl transition-all outline-none">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-end">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">I am a...</label>
                                <select id="role-select" name="role" required onchange="toggleDoctorFields()"
                                    class="w-full px-4 py-3.5 bg-white text-gray-700 border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 rounded-xl transition-all outline-none">
                                    <option value="">-- Select --</option>
                                    <option value="patient" {{ old('role') === 'patient' ? 'selected' : '' }}>Patient</option>
                                    <option value="doctor" {{ old('role') === 'doctor' ? 'selected' : '' }}>Doctor</option>
                                </select>
                                @error('role') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Profile Photo</label>
                                <input type="file" name="profile_photo" accept="image/jpeg,image/png,image/jpg"
                                    class="block w-full text-sm text-gray-600 file:mr-3 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                            </div>
                        </div>

                        <div id="doctor-fields" class="hidden space-y-4 p-5 mt-2 bg-blue-50/50 rounded-2xl border-2 border-blue-100">
                            <p class="text-xs font-bold text-blue-700 uppercase tracking-wider flex items-center gap-2">
                                🩺 Informations médecin
                            </p>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Spécialisation</label>
                                    <input type="text" name="specialization" value="{{ old('specialization') }}" class="w-full px-3 py-2 bg-white text-gray-700 border border-gray-300 focus:border-blue-500 rounded-lg outline-none">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Tarif (DH)</label>
                                    <input type="number" name="consultation_fee" value="{{ old('consultation_fee') }}" class="w-full px-3 py-2 bg-white text-gray-700 border border-gray-300 focus:border-blue-500 rounded-lg outline-none">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Biographie</label>
                                <textarea name="biography" rows="2" class="w-full px-3 py-2 bg-white text-gray-700 border border-gray-300 focus:border-blue-500 rounded-lg outline-none">{{ old('biography') }}</textarea>
                            </div>
                        </div>

                        <button type="submit" 
                                class="w-full mt-6 py-4 text-white font-bold rounded-xl shadow-[0_10px_20px_rgba(37,99,235,0.3)] transform transition hover:-translate-y-1 active:scale-95" 
                                style="background-color: #2563eb;">
                            S'inscrire →
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleDoctorFields() {
            const role = document.getElementById('role-select').value;
            const doctorFields = document.getElementById('doctor-fields');
            if (role === 'doctor') {
                doctorFields.classList.remove('hidden');
                doctorFields.querySelectorAll('input:not([type="hidden"]), textarea').forEach(el => el.required = true);
            } else {
                doctorFields.classList.add('hidden');
                doctorFields.querySelectorAll('input, textarea').forEach(el => el.required = false);
            }
        }
        document.addEventListener('DOMContentLoaded', toggleDoctorFields);
    </script>
</x-guest-layout>