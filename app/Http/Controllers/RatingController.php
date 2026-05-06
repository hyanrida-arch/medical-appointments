<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * Submit a rating for a completed appointment
     */
    public function store(Request $request, Appointment $appointment)
    {
        // Verify: only the patient of this appointment can rate
        if ($appointment->patient_id !== Auth::id()) {
            abort(403);
        }

        // Verify: only completed appointments can be rated
        if ($appointment->status !== 'completed') {
            return redirect()->back()->with('error', __('messages.cannot_rate_yet'));
        }

        // Verify: not already rated
        if (Rating::where('appointment_id', $appointment->id)->exists()) {
            return redirect()->back()->with('error', __('messages.already_rated'));
        }

        $request->validate([
            'stars' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Rating::create([
            'patient_id' => $appointment->patient_id,
            'doctor_id' => $appointment->doctor_id,
            'appointment_id' => $appointment->id,
            'stars' => $request->stars,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', __('messages.rating_submitted'));
    }
}