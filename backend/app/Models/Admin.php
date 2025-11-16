<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Tentukan nama tabel admin
     */
    protected $table = 'admin'; // PENTING!

    /**
     * Field yang boleh diisi.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Field yang disembunyikan.
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
     *             RELATIONS
     * ================================
     */

    // Admin dapat membuat banyak event
    public function eventsCreated()
    {
        return $this->hasMany(Event::class, 'created_by');
    }

    // Admin dapat membuat sertifikat (opsional digunakan)
    public function certificatesGenerated()
    {
        return $this->hasMany(Certificate::class, 'generated_by');
    }
}
