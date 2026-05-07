<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Generic dashboard — redirects to role-specific dashboard
Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user->isDoctor()) {
        return redirect()->route('doctor.dashboard');
    }
    return redirect()->route('patient.dashboard');
})->middleware(['auth'])->name('dashboard');

// Doctor routes
Route::middleware(['auth', 'doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Doctor\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/appointments', [\App\Http\Controllers\Doctor\AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/{appointment}', [\App\Http\Controllers\Doctor\AppointmentController::class, 'show'])->name('appointments.show');
    Route::patch('/appointments/{appointment}/accept', [\App\Http\Controllers\Doctor\AppointmentController::class, 'accept'])->name('appointments.accept');
    Route::patch('/appointments/{appointment}/refuse', [\App\Http\Controllers\Doctor\AppointmentController::class, 'refuse'])->name('appointments.refuse');
    Route::patch('/appointments/{appointment}/complete', [\App\Http\Controllers\Doctor\AppointmentController::class, 'complete'])->name('appointments.complete');

    // PDF export
    Route::get('/appointments-pdf-export', [\App\Http\Controllers\PdfController::class, 'doctorAppointments'])->name('appointments.export-pdf');
});

// Patient routes
Route::middleware(['auth', 'patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Patient\DashboardController::class, 'index'])->name('dashboard');

    // Doctors
    Route::get('/doctors', [\App\Http\Controllers\Patient\DoctorController::class, 'index'])->name('doctors.index');
    Route::get('/doctors/{doctor}', [\App\Http\Controllers\Patient\DoctorController::class, 'show'])->name('doctors.show');

    // Appointments
    Route::get('/appointments', [\App\Http\Controllers\Patient\AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/create', [\App\Http\Controllers\Patient\AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [\App\Http\Controllers\Patient\AppointmentController::class, 'store'])->name('appointments.store');
    Route::patch('/appointments/{appointment}/cancel', [\App\Http\Controllers\Patient\AppointmentController::class, 'cancel'])->name('appointments.cancel');

    // Ratings
    Route::post('/appointments/{appointment}/rate', [\App\Http\Controllers\RatingController::class, 'store'])->name('appointments.rate');

    // PDF export
    Route::get('/appointments-pdf-export', [\App\Http\Controllers\PdfController::class, 'patientAppointments'])->name('appointments.export-pdf');
});

// Messaging — accessible to both doctors and patients
Route::middleware(['auth'])->prefix('messages')->name('messages.')->group(function () {
    Route::get('/', [\App\Http\Controllers\MessageController::class, 'index'])->name('index');
    Route::get('/start/{user}', [\App\Http\Controllers\MessageController::class, 'startWith'])->name('start');
    Route::get('/{conversation}', [\App\Http\Controllers\MessageController::class, 'show'])->name('show');
    Route::post('/{conversation}', [\App\Http\Controllers\MessageController::class, 'store'])->name('store');
    Route::delete('/{conversation}', [\App\Http\Controllers\MessageController::class, 'destroy'])->name('destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Language switcher
Route::get('/locale/{locale}', [\App\Http\Controllers\LocaleController::class, 'switch'])->name('locale.switch');

require __DIR__.'/auth.php';