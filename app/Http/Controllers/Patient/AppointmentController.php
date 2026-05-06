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
     * List the patient's own appointments.
     */
    public function index(Request $request)
    {
        $query = Auth::user()->patientAppointments()->with('doctor.doctorProfile');

        // Filter by upcoming/past
        if ($request->filter === 'upcoming') {
            $query->where('appointment_date', '>=', now())
                  ->whereIn('status', ['pending', 'accepted']);
        } elseif ($request->filter === 'past') {
            $query->where(function ($q) {
                $q->where('appointment_date', '<', now())
                  ->orWhereIn('status', ['completed', 'refused', 'cancelled']);
            });
        }

        $appointments = $query->orderBy('appointment_date', 'desc')->paginate(10);

        return view('patient.appointments.index', compact('appointments'));
    }

    /**
     * Show the booking form for a specific doctor.
     */
    public function create(Request $request)
    {
        $doctorId = $request->doctor_id;
        $doctor = User::where('id', $doctorId)->where('role', 'doctor')->with('doctorProfile')->firstOrFail();

        return view('patient.appointments.create', compact('doctor'));
    }

    /**
     * Save a new appointment booking.
     */
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => ['required', 'exists:users,id'],
            'appointment_date' => ['required', 'date', 'after:now'],
            'reason' => ['nullable', 'string', 'max:1000'],
        ]);

        // Make sure the chosen user is actually a doctor
        $doctor = User::find($request->doctor_id);
        if (!$doctor || !$doctor->isDoctor()) {
            return redirect()->back()->with('error', 'Invalid doctor selected.');
        }

        Appointment::create([
            'patient_id' => Auth::id(),
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'reason' => $request->reason,
            'status' => Appointment::STATUS_PENDING,
        ]);

        return redirect()->route('patient.appointments.index')
            ->with('success', __('messages.appointment_request_sent'));
    }

    /**
     * Cancel an appointment.
     */
    public function cancel(Appointment $appointment)
    {
        // Make sure this appointment belongs to the logged-in patient
        if ($appointment->patient_id !== Auth::id()) {
            abort(403, 'This appointment does not belong to you.');
        }

        // Only pending or accepted appointments can be cancelled
        if (!in_array($appointment->status, [Appointment::STATUS_PENDING, Appointment::STATUS_ACCEPTED])) {
            return redirect()->back()->with('error', 'This appointment cannot be cancelled.');
        }

        $appointment->update(['status' => Appointment::STATUS_CANCELLED]);

        return redirect()->back()->with('success', __('messages.appointment_cancelled'));
    }
}
