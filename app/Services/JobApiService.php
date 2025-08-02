<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class JobApiService
{
    protected $adzunaAppId;
    protected $adzunaAppKey;
    protected $remotiveApiKey;

    public function __construct()
    {
        $this->adzunaAppId = config('services.adzuna.app_id');
        $this->adzunaAppKey = config('services.adzuna.app_key');
        $this->remotiveApiKey = config('services.remotive.api_key');
    }

    /**
     * Fetch jobs from Adzuna API
     */
    public function fetchFromAdzuna($params = [])
    {
        try {
            $defaultParams = [
                'app_id' => $this->adzunaAppId,
                'app_key' => $this->adzunaAppKey,
                'results_per_page' => 20,
                'what' => $params['search'] ?? '',
                'where' => $params['location'] ?? 'Nigeria',
                'category' => $params['category'] ?? '',
            ];

            $queryParams = array_merge($defaultParams, $params);
            
            $response = Http::get('https://api.adzuna.com/v1/api/jobs/ng/search/1', $queryParams);

            if ($response->successful()) {
                $data = $response->json();
                return $this->formatAdzunaJobs($data['results'] ?? []);
            }

            Log::error('Adzuna API Error: ' . $response->body());
            return [];
        } catch (\Exception $e) {
            Log::error('Adzuna API Exception: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Fetch jobs from Remotive API
     */
    public function fetchFromRemotive($params = [])
    {
        try {
            $queryParams = [
                'limit' => $params['limit'] ?? 20,
                'search' => $params['search'] ?? '',
                'category' => $params['category'] ?? '',
            ];

            $response = Http::get('https://remotive.io/api/remote-jobs', $queryParams);

            if ($response->successful()) {
                $data = $response->json();
                return $this->formatRemotiveJobs($data['jobs'] ?? []);
            }

            Log::error('Remotive API Error: ' . $response->body());
            return [];
        } catch (\Exception $e) {
            Log::error('Remotive API Exception: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get mock jobs for development (when API keys are not available)
     */
    public function getMockJobs($params = [])
    {
        $mockJobs = [
            [
                'id' => 'mock_1',
                'title' => 'Senior Laravel Developer',
                'company' => 'Tech Solutions Ltd',
                'location' => 'Lagos, Nigeria',
                'salary_min' => '₦500,000',
                'salary_max' => '₦800,000',
                'description' => 'We are looking for an experienced Laravel developer to join our growing team. You will be responsible for developing and maintaining web applications using Laravel framework.',
                'job_type' => 'full-time',
                'external_url' => '#',
                'source' => 'mock',
                'category' => 'Technology',
                'requirements' => ['Laravel 8+', 'PHP 7.4+', 'MySQL', 'Git'],
                'benefits' => ['Health Insurance', 'Remote Work', 'Learning Budget'],
                'posted_date' => now()->subDays(2)->toDateString(),
            ],
            [
                'id' => 'mock_2',
                'title' => 'Digital Marketing Specialist',
                'company' => 'Marketing Pro Agency',
                'location' => 'Abuja, Nigeria',
                'salary_min' => '₦300,000',
                'salary_max' => '₦500,000',
                'description' => 'Join our marketing team as a Digital Marketing Specialist. You will manage social media campaigns, SEO, and content marketing strategies.',
                'job_type' => 'full-time',
                'external_url' => '#',
                'source' => 'mock',
                'category' => 'Marketing',
                'requirements' => ['Google Ads', 'Facebook Ads', 'SEO', 'Content Writing'],
                'benefits' => ['Flexible Hours', 'Performance Bonus', 'Training'],
                'posted_date' => now()->subDays(1)->toDateString(),
            ],
            [
                'id' => 'mock_3',
                'title' => 'UI/UX Designer',
                'company' => 'Creative Studio',
                'location' => 'Remote',
                'salary_min' => '₦400,000',
                'salary_max' => '₦600,000',
                'description' => 'We need a talented UI/UX designer to create amazing user experiences for our web and mobile applications.',
                'job_type' => 'remote',
                'external_url' => '#',
                'source' => 'mock',
                'category' => 'Design',
                'requirements' => ['Figma', 'Adobe XD', 'Prototyping', 'User Research'],
                'benefits' => ['Remote Work', 'Flexible Schedule', 'Equipment Allowance'],
                'posted_date' => now()->toDateString(),
            ],
            [
                'id' => 'mock_4',
                'title' => 'Sales Representative',
                'company' => 'Sales Force Nigeria',
                'location' => 'Port Harcourt, Nigeria',
                'salary_min' => '₦200,000',
                'salary_max' => '₦400,000',
                'description' => 'Looking for an energetic sales representative to drive our sales in the Port Harcourt region.',
                'job_type' => 'full-time',
                'external_url' => '#',
                'source' => 'mock',
                'category' => 'Sales',
                'requirements' => ['Sales Experience', 'Communication Skills', 'CRM Knowledge'],
                'benefits' => ['Commission', 'Car Allowance', 'Health Insurance'],
                'posted_date' => now()->subDays(3)->toDateString(),
            ],
            [
                'id' => 'mock_5',
                'title' => 'Financial Analyst',
                'company' => 'Finance Corp',
                'location' => 'Lagos, Nigeria',
                'salary_min' => '₦450,000',
                'salary_max' => '₦700,000',
                'description' => 'We are seeking a detail-oriented Financial Analyst to join our finance team and help drive business decisions.',
                'job_type' => 'full-time',
                'external_url' => '#',
                'source' => 'mock',
                'category' => 'Finance',
                'requirements' => ['Excel', 'Financial Modeling', 'SQL', 'PowerBI'],
                'benefits' => ['Pension', 'Health Insurance', 'Professional Development'],
                'posted_date' => now()->subDays(4)->toDateString(),
            ],
        ];

        // Apply search filter if provided
        if (!empty($params['search'])) {
            $search = strtolower($params['search']);
            $mockJobs = array_filter($mockJobs, function($job) use ($search) {
                return strpos(strtolower($job['title']), $search) !== false ||
                       strpos(strtolower($job['company']), $search) !== false ||
                       strpos(strtolower($job['description']), $search) !== false;
            });
        }

        // Apply category filter if provided
        if (!empty($params['category'])) {
            $mockJobs = array_filter($mockJobs, function($job) use ($params) {
                return strtolower($job['category']) === strtolower($params['category']);
            });
        }

        // Apply location filter if provided
        if (!empty($params['location'])) {
            $location = strtolower($params['location']);
            $mockJobs = array_filter($mockJobs, function($job) use ($location) {
                return strpos(strtolower($job['location']), $location) !== false;
            });
        }

        return array_values($mockJobs);
    }

    /**
     * Format Adzuna jobs to standard format
     */
    private function formatAdzunaJobs($jobs)
    {
        return collect($jobs)->map(function ($job) {
            return [
                'id' => 'adzuna_' . $job['id'],
                'title' => $job['title'],
                'company' => $job['company']['display_name'] ?? 'Unknown Company',
                'location' => $job['location']['display_name'] ?? 'Unknown Location',
                'salary_min' => isset($job['salary_min']) ? '₦' . number_format($job['salary_min']) : null,
                'salary_max' => isset($job['salary_max']) ? '₦' . number_format($job['salary_max']) : null,
                'description' => $job['description'],
                'job_type' => $job['contract_type'] ?? 'full-time',
                'external_url' => $job['redirect_url'],
                'source' => 'adzuna',
                'category' => $job['category']['label'] ?? 'General',
                'posted_date' => isset($job['created']) ? date('Y-m-d', strtotime($job['created'])) : now()->toDateString(),
            ];
        })->toArray();
    }

    /**
     * Format Remotive jobs to standard format
     */
    private function formatRemotiveJobs($jobs)
    {
        return collect($jobs)->map(function ($job) {
            return [
                'id' => 'remotive_' . $job['id'],
                'title' => $job['title'],
                'company' => $job['company_name'],
                'location' => 'Remote',
                'salary_min' => $job['salary'] ?? null,
                'salary_max' => null,
                'description' => $job['description'],
                'job_type' => 'remote',
                'external_url' => $job['url'],
                'source' => 'remotive',
                'category' => $job['category'],
                'posted_date' => isset($job['publication_date']) ? date('Y-m-d', strtotime($job['publication_date'])) : now()->toDateString(),
            ];
        })->toArray();
    }

    /**
     * Fetch jobs from all available sources
     */
    public function fetchJobs($params = [])
    {
        $allJobs = [];

        // Try Adzuna first if API keys are available
        if ($this->adzunaAppId && $this->adzunaAppKey) {
            $adzunaJobs = $this->fetchFromAdzuna($params);
            $allJobs = array_merge($allJobs, $adzunaJobs);
        }

        // Try Remotive if API key is available
        if ($this->remotiveApiKey) {
            $remotiveJobs = $this->fetchFromRemotive($params);
            $allJobs = array_merge($allJobs, $remotiveJobs);
        }

        // If no API keys or no results, use mock data
        if (empty($allJobs)) {
            $allJobs = $this->getMockJobs($params);
        }

        return $allJobs;
    }
}