<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * List appointments of the connected patient.
     */
    public function index(Request $request)
    {
        $query = Appointment::where('patient_id', Auth::id())
            ->with(['doctor.doctorProfile'])
            ->orderBy('appointment_date', 'desc');

        if ($request->filter === 'upcoming') {
            $query->where('appointment_date', '>=', now())
                  ->whereIn('status', ['pending', 'accepted']);
        } elseif ($request->filter === 'past') {
            $query->where(function ($q) {
                $q->where('appointment_date', '<', now())
                  ->orWhereIn('status', ['completed', 'refused', 'cancelled']);
            });
        }

        $appointments = $query->paginate(10);

        return view('patient.appointments.index', compact('appointments'));
    }

    /**
     * Show the booking form (with optional preselected doctor).
     */
    public function create(Request $request)
    {
        $doctors = User::where('role', 'doctor')
            ->with('doctorProfile')
            ->orderBy('first_name')
            ->get();

        $preselectedDoctorId = $request->query('doctor');

        return view('patient.appointments.create', compact('doctors', 'preselectedDoctorId'));
    }

    /**
     * Store a new appointment request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after:now',
            'reason' => 'nullable|string|max:1000',
        ]);

        // Verify the chosen user is actually a doctor
        $doctor = User::where('id', $request->doctor_id)->where('role', 'doctor')->first();
        if (!$doctor) {
            return back()->withErrors(['doctor_id' => 'Invalid doctor.']);
        }

        Appointment::create([
            'patient_id' => Auth::id(),
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->route('patient.appointments.index')
            ->with('success', __('messages.appointment_request_sent'));
    }

    /**
     * Cancel an appointment.
     */
    public function cancel(Appointment $appointment)
    {
        if ($appointment->patient_id !== Auth::id()) {
            abort(403);
        }

        if (!in_array($appointment->status, ['pending', 'accepted'])) {
            return back()->with('error', 'Cannot cancel this appointment.');
        }

        $appointment->update(['status' => 'cancelled']);

        return back()->with('success', __('messages.appointment_cancelled'));
    }
}