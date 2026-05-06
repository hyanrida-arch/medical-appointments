<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'profile_photo',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isDoctor(): bool
    {
        return $this->role === 'doctor';
    }

    public function isPatient(): bool
    {
        return $this->role === 'patient';
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function getProfilePhotoUrlAttribute(): ?string
    {
        return $this->profile_photo ? asset('storage/' . $this->profile_photo) : null;
    }

    public function doctorProfile()
    {
        return $this->hasOne(DoctorProfile::class);
    }

    public function patientAppointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    public function doctorAppointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function ratingsGiven()
    {
        return $this->hasMany(Rating::class, 'patient_id');
    }

    public function ratingsReceived()
    {
        return $this->hasMany(Rating::class, 'doctor_id');
    }

    public function getAverageRatingAttribute(): float
    {
        return round($this->ratingsReceived()->avg('stars') ?? 0, 1);
    }

    public function getRatingsCountAttribute(): int
    {
        return $this->ratingsReceived()->count();
    }
}