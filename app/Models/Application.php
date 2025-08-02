<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_id',
        'employer_id',
        'status',
        'cover_letter',
        'resume_path',
        'viewed_at',
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeViewed($query)
    {
        return $query->where('status', 'viewed');
    }

    // Helper methods
    public function markAsViewed()
    {
        $this->update([
            'status' => 'viewed',
            'viewed_at' => now(),
        ]);
    }
}
