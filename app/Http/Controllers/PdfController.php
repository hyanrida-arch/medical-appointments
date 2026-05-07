<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PdfController extends Controller
{
    /**
     * Export all appointments of the connected patient as PDF.
     */
    public function patientAppointments()
    {
        $user = Auth::user();

        if (!$user->isPatient()) {
            abort(403);
        }

        $appointments = Appointment::where('patient_id', $user->id)
            ->with(['doctor.doctorProfile'])
            ->orderBy('appointment_date', 'desc')
            ->get();

        $pdf = Pdf::loadView('pdf.patient-appointments', [
            'user' => $user,
            'appointments' => $appointments,
            'generatedAt' => now(),
        ]);

        $pdf->setPaper('A4', 'portrait');

        $filename = 'mes-rendez-vous-' . now()->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Export all appointments of the connected doctor as PDF.
     */
    public function doctorAppointments()
    {
        $user = Auth::user();

        if (!$user->isDoctor()) {
            abort(403);
        }

        $appointments = Appointment::where('doctor_id', $user->id)
            ->with(['patient'])
            ->orderBy('appointment_date', 'desc')
            ->get();

        $pdf = Pdf::loadView('pdf.doctor-appointments', [
            'user' => $user,
            'appointments' => $appointments,
            'generatedAt' => now(),
        ]);

        $pdf->setPaper('A4', 'portrait');

        $filename = 'mes-consultations-' . now()->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }
}