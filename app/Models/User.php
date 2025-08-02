<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'bio',
        'avatar',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationships
    public function jobs()
    {
        return $this->hasMany(Job::class, 'employer_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function resumes()
    {
        return $this->hasMany(Resume::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function employerProfile()
    {
        return $this->hasOne(EmployerProfile::class);
    }

    // Helper methods
    public function isJobSeeker()
    {
        return $this->role === 'job_seeker';
    }

    public function isEmployer()
    {
        return $this->role === 'employer';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function hasAppliedTo($jobId)
    {
        return $this->applications()->where('job_id', $jobId)->exists();
    }

    public function hasBookmarked($jobId)
    {
        return $this->bookmarks()->where('job_id', $jobId)->exists();
    }
}
