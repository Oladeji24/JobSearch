<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'employer_id',
        'category_id',
        'title',
        'description',
        'company_name',
        'location',
        'salary_min',
        'salary_max',
        'job_type',
        'status',
        'closing_date',
        'external_url',
        'external_id',
        'source',
        'requirements',
        'benefits',
    ];

    protected $casts = [
        'closing_date' => 'date',
        'requirements' => 'array',
        'benefits' => 'array',
    ];

    // Relationships
    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInternal($query)
    {
        return $query->where('source', 'internal');
    }

    public function scopeExternal($query)
    {
        return $query->where('source', '!=', 'internal');
    }

    // Helper methods
    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isExpired()
    {
        return $this->closing_date && $this->closing_date->isPast();
    }

    public function getSalaryRangeAttribute()
    {
        if ($this->salary_min && $this->salary_max) {
            return $this->salary_min . ' - ' . $this->salary_max;
        }
        return $this->salary_min ?: $this->salary_max ?: 'Not specified';
    }
}
