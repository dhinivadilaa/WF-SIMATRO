<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Field yang boleh diisi (mass assignable)
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Field yang akan disembunyikan.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * ================================
     *          RELATIONS
     * ================================
     */

    // Relasi ke absensi
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // Relasi ke sertifikat
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    // Relasi ke feedback
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}
