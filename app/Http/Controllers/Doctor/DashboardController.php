<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $doctorId = Auth::id();

        // Counts by status
        $pendingCount = Appointment::where('doctor_id', $doctorId)
            ->where('status', 'pending')
            ->count();

        $acceptedCount = Appointment::where('doctor_id', $doctorId)
            ->where('status', 'accepted')
            ->count();

        $completedCount = Appointment::where('doctor_id', $doctorId)
            ->where('status', 'completed')
            ->count();

        $totalCount = Appointment::where('doctor_id', $doctorId)->count();

        // Today's appointments (any status, today)
        $todayAppointments = Appointment::where('doctor_id', $doctorId)
            ->whereDate('appointment_date', today())
            ->with('patient')
            ->orderBy('appointment_date')
            ->get();

        return view('doctor.dashboard', compact(
            'pendingCount',
            'acceptedCount',
            'completedCount',
            'totalCount',
            'todayAppointments'
        ));
    }
}