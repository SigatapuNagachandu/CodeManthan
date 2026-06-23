<?php

namespace App\Models;

use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $connection = 'mongodb';
    protected $collection = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // super_admin, organizer, candidate, proctor
        'otp_code',
        'otp_expires_at',
        'google_id',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'otp_expires_at' => 'datetime',
        ];
    }

    /**
     * Role Helpers
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isOrganizer(): bool
    {
        return $this->role === 'organizer';
    }

    public function isCandidate(): bool
    {
        return $this->role === 'candidate';
    }

    public function isProctor(): bool
    {
        return $this->role === 'proctor';
    }

    /**
     * Relationships
     */
    public function hackathons()
    {
        return $this->hasMany(Hackathon::class, 'organizer_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'candidate_id');
    }

    public function cheatingEvents()
    {
        return $this->hasMany(CheatingEvent::class, 'candidate_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }
}
