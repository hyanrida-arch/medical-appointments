<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\DoctorProfile;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['nullable', 'string', 'max:20'],
            'role' => ['required', 'in:doctor,patient'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // Doctor-only fields — required if role is doctor
            'specialization' => ['required_if:role,doctor', 'nullable', 'string', 'max:255'],
            'consultation_fee' => ['required_if:role,doctor', 'nullable', 'numeric', 'min:0'],
            'biography' => ['nullable', 'string', 'max:2000'],
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        // If registering as a doctor, create their profile
        if ($user->role === 'doctor') {
            DoctorProfile::create([
                'user_id' => $user->id,
                'specialization' => $request->specialization,
                'consultation_fee' => $request->consultation_fee,
                'biography' => $request->biography,
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
