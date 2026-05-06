<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\DoctorProfile;
use App\Models\User;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'doctor')->with('doctorProfile');

        // Search by name or specialization
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhereHas('doctorProfile', function ($subQ) use ($search) {
                      $subQ->where('specialization', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by specialization
        if ($request->filled('specialization')) {
            $query->whereHas('doctorProfile', function ($subQ) use ($request) {
                $subQ->where('specialization', $request->specialization);
            });
        }

        // Filter by price range
        if ($request->filled('min_price') || $request->filled('max_price')) {
            $query->whereHas('doctorProfile', function ($subQ) use ($request) {
                if ($request->filled('min_price')) {
                    $subQ->where('consultation_fee', '>=', $request->min_price);
                }
                if ($request->filled('max_price')) {
                    $subQ->where('consultation_fee', '<=', $request->max_price);
                }
            });
        }

        // Sort
        $sort = $request->get('sort', 'name_asc');
        switch ($sort) {
            case 'price_asc':
                $query->join('doctor_profiles', 'users.id', '=', 'doctor_profiles.user_id')
                      ->orderBy('doctor_profiles.consultation_fee', 'asc')
                      ->select('users.*');
                break;
            case 'price_desc':
                $query->join('doctor_profiles', 'users.id', '=', 'doctor_profiles.user_id')
                      ->orderBy('doctor_profiles.consultation_fee', 'desc')
                      ->select('users.*');
                break;
            case 'top_rated':
                $query->withCount('ratingsReceived')
                      ->withAvg('ratingsReceived', 'stars')
                      ->orderByDesc('ratings_received_avg_stars')
                      ->orderByDesc('ratings_received_count');
                break;
            case 'name_desc':
                $query->orderBy('first_name', 'desc');
                break;
            case 'name_asc':
            default:
                $query->orderBy('first_name', 'asc');
                break;
        }

        $doctors = $query->paginate(12);

        $specializations = DoctorProfile::distinct()->pluck('specialization')->filter()->sort()->values();

        return view('patient.doctors.index', compact('doctors', 'specializations'));
    }

    public function show(User $doctor)
    {
        if (!$doctor->isDoctor()) {
            abort(404);
        }

        $doctor->load(['doctorProfile', 'ratingsReceived.patient']);

        return view('patient.doctors.show', compact('doctor'));
    }
}