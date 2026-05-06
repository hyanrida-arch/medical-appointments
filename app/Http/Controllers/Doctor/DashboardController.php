<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $doctor = Auth::user();

        // Count appointments by status
        $stats = [
            'pending' => $doctor->doctorAppointments()->where('status', Appointment::STATUS_PENDING)->count(),
            'accepted' => $doctor->doctorAppointments()->where('status', Appointment::STATUS_ACCEPTED)->count(),
            'completed' => $doctor->doctorAppointments()->where('status', Appointment::STATUS_COMPLETED)->count(),
            'total' => $doctor->doctorAppointments()->count(),
        ];

        // Today's appointments
        $todayAppointments = $doctor->doctorAppointments()
            ->whereDate('appointment_date', today())
            ->whereIn('status', [Appointment::STATUS_ACCEPTED, Appointment::STATUS_PENDING])
            ->with('patient')
            ->orderBy('appointment_date')
            ->get();

        return view('doctor.dashboard', compact('stats', 'todayAppointments'));
    }
}