<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * List all appointments for this doctor, with optional filters.
     */
    public function index(Request $request)
    {
        $query = Auth::user()->doctorAppointments()->with('patient');

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->date);
        }

        $appointments = $query->orderBy('appointment_date', 'desc')->paginate(10);

        return view('doctor.appointments.index', compact('appointments'));
    }

    /**
     * Show details of a single appointment.
     */
    public function show(Appointment $appointment)
    {
        $this->authorizeAppointment($appointment);

        $appointment->load('patient');

        return view('doctor.appointments.show', compact('appointment'));
    }

    /**
     * Accept a pending appointment.
     */
    public function accept(Appointment $appointment)
    {
        $this->authorizeAppointment($appointment);

        if ($appointment->status !== Appointment::STATUS_PENDING) {
            return redirect()->back()->with('error', 'Only pending appointments can be accepted.');
        }

        $appointment->update(['status' => Appointment::STATUS_ACCEPTED]);

        return redirect()->back()->with('success', __('messages.appointment_accepted'));
    }

    /**
     * Refuse a pending appointment.
     */
    public function refuse(Appointment $appointment)
    {
        $this->authorizeAppointment($appointment);

        if ($appointment->status !== Appointment::STATUS_PENDING) {
            return redirect()->back()->with('error', 'Only pending appointments can be refused.');
        }

        $appointment->update(['status' => Appointment::STATUS_REFUSED]);

        return redirect()->back()->with('success', __('messages.appointment_refused'));
    }

    /**
     * Mark an appointment as completed and save consultation notes.
     */
    public function complete(Request $request, Appointment $appointment)
    {
        $this->authorizeAppointment($appointment);

        if ($appointment->status !== Appointment::STATUS_ACCEPTED) {
            return redirect()->back()->with('error', 'Only accepted appointments can be completed.');
        }

        $request->validate([
            'consultation_notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $appointment->update([
            'status' => Appointment::STATUS_COMPLETED,
            'consultation_notes' => $request->consultation_notes,
        ]);

        return redirect()->route('doctor.appointments.show', $appointment)
            ->with('success', __('messages.appointment_completed'));
    }

    /**
     * Make sure the appointment belongs to the authenticated doctor.
     */
    private function authorizeAppointment(Appointment $appointment): void
    {
        if ($appointment->doctor_id !== Auth::id()) {
            abort(403, 'This appointment does not belong to you.');
        }
    }
}
