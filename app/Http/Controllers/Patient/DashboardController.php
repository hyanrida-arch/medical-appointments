<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $patient = Auth::user();

        $stats = [
            'pending' => $patient->patientAppointments()->where('status', Appointment::STATUS_PENDING)->count(),
            'accepted' => $patient->patientAppointments()->where('status', Appointment::STATUS_ACCEPTED)->count(),
            'completed' => $patient->patientAppointments()->where('status', Appointment::STATUS_COMPLETED)->count(),
            'total' => $patient->patientAppointments()->count(),
        ];

        $upcomingAppointments = $patient->patientAppointments()
            ->whereIn('status', [Appointment::STATUS_PENDING, Appointment::STATUS_ACCEPTED])
            ->where('appointment_date', '>=', now())
            ->with('doctor.doctorProfile')
            ->orderBy('appointment_date')
            ->take(5)
            ->get();

        return view('patient.dashboard', compact('stats', 'upcomingAppointments'));
    }
}