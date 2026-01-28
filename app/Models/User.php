<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $fillable = ['name', 'email', 'password', 'role', 'status'];

    protected $hidden = ['password', 'remember_token'];

    // Relasi ke profil sekolah jika role user adalah 'school'
    public function school()
    {
        return $this->hasOne(School::class, 'user_id');
    }

    // Helper untuk cek role
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    public function isValidator()
    {
        return $this->role === 'validator';
    }
}
