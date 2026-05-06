<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\DoctorProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        // Eager-load doctor profile if needed
        if ($user->isDoctor()) {
            $user->load('doctorProfile');
        }

        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Fill basic user fields
        $user->fill($request->safe()->only(['first_name', 'last_name', 'email', 'phone']));

        // If email was changed, mark it as unverified again
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete the old photo if there is one
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            // Store the new photo and save its path
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo = $path;
        }

        $user->save();

        // If user is a doctor, update their doctor profile too
        if ($user->isDoctor()) {
            $user->doctorProfile()->updateOrCreate(
                ['user_id' => $user->id],
                $request->safe()->only(['specialization', 'consultation_fee', 'biography'])
            );
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Delete the photo file if it exists
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}