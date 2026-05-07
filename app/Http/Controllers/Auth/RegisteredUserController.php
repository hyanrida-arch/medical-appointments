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
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'phone' => 'nullable|string|max:30',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:patient,doctor',
            'profile_photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            // Doctor fields (only required if role=doctor)
            'specialization' => 'required_if:role,doctor|nullable|string|max:255',
            'consultation_fee' => 'required_if:role,doctor|nullable|numeric|min:0',
            'biography' => 'nullable|string|max:2000',
        ]);

        // Handle profile photo upload (BEFORE creating the user)
        $profilePhotoPath = null;
        if ($request->hasFile('profile_photo')) {
            $profilePhotoPath = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        // Create user
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'profile_photo' => $profilePhotoPath,
        ]);

        // Create doctor profile if role is doctor
        if ($request->role === 'doctor') {
            DoctorProfile::create([
                'user_id' => $user->id,
                'specialization' => $request->specialization,
                'consultation_fee' => $request->consultation_fee,
                'biography' => $request->biography,
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        // Redirect to role-specific dashboard
        if ($user->isDoctor()) {
            return redirect()->route('doctor.dashboard');
        }

        return redirect()->route('patient.dashboard');
    }
}