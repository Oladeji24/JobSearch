<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Category;
use App\Services\JobApiService;

class JobController extends Controller
{
    protected $jobApiService;

    public function __construct(JobApiService $jobApiService)
    {
        $this->jobApiService = $jobApiService;
    }

    /**
     * Display a listing of jobs with search and filters
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $location = $request->get('location');
        $category = $request->get('category');
        $jobType = $request->get('job_type');
        $source = $request->get('source', 'all'); // all, internal, external

        // Get categories for filter dropdown
        $categories = Category::active()->get();

        // Initialize jobs collection
        $jobs = collect();

        // Get internal jobs (from database)
        if ($source === 'all' || $source === 'internal') {
            $internalJobs = Job::with(['category', 'employer'])
                ->active()
                ->when($search, function ($query) use ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%")
                          ->orWhere('description', 'like', "%{$search}%")
                          ->orWhere('company_name', 'like', "%{$search}%");
                    });
                })
                ->when($location, function ($query) use ($location) {
                    $query->where('location', 'like', "%{$location}%");
                })
                ->when($category, function ($query) use ($category) {
                    $query->whereHas('category', function ($q) use ($category) {
                        $q->where('slug', $category);
                    });
                })
                ->when($jobType, function ($query) use ($jobType) {
                    $query->where('job_type', $jobType);
                })
                ->latest()
                ->get();

            // Format internal jobs to match API format
            $formattedInternalJobs = $internalJobs->map(function ($job) {
                return [
                    'id' => 'internal_' . $job->id,
                    'title' => $job->title,
                    'company' => $job->company_name,
                    'location' => $job->location,
                    'salary_min' => $job->salary_min,
                    'salary_max' => $job->salary_max,
                    'salary_range' => $job->salary_range,
                    'description' => $job->description,
                    'job_type' => $job->job_type,
                    'external_url' => null,
                    'source' => 'internal',
                    'category' => $job->category->name ?? 'General',
                    'posted_date' => $job->created_at->toDateString(),
                    'requirements' => $job->requirements,
                    'benefits' => $job->benefits,
                    'model' => $job, // Keep reference to model for internal jobs
                ];
            });

            $jobs = $jobs->merge($formattedInternalJobs);
        }

        // Get external jobs (from APIs)
        if ($source === 'all' || $source === 'external') {
            $apiParams = [
                'search' => $search,
                'location' => $location,
                'category' => $category,
                'limit' => 20,
            ];

            $externalJobs = $this->jobApiService->fetchJobs($apiParams);
            $jobs = $jobs->merge($externalJobs);
        }

        // Paginate results manually
        $perPage = 12;
        $currentPage = $request->get('page', 1);
        $total = $jobs->count();
        $jobs = $jobs->forPage($currentPage, $perPage);

        // Create pagination info
        $pagination = [
            'current_page' => $currentPage,
            'per_page' => $perPage,
            'total' => $total,
            'last_page' => ceil($total / $perPage),
            'from' => ($currentPage - 1) * $perPage + 1,
            'to' => min($currentPage * $perPage, $total),
        ];

        return view('jobs.index', compact(
            'jobs', 
            'categories', 
            'search', 
            'location', 
            'category', 
            'jobType', 
            'source',
            'pagination'
        ));
    }

    /**
     * Display the specified job
     */
    public function show($id)
    {
        // Check if it's an internal job
        if (str_starts_with($id, 'internal_')) {
            $jobId = str_replace('internal_', '', $id);
            $job = Job::with(['category', 'employer', 'employer.employerProfile'])
                ->findOrFail($jobId);
            
            $jobData = [
                'id' => 'internal_' . $job->id,
                'title' => $job->title,
                'company' => $job->company_name,
                'location' => $job->location,
                'salary_min' => $job->salary_min,
                'salary_max' => $job->salary_max,
                'salary_range' => $job->salary_range,
                'description' => $job->description,
                'job_type' => $job->job_type,
                'external_url' => null,
                'source' => 'internal',
                'category' => $job->category->name ?? 'General',
                'posted_date' => $job->created_at->toDateString(),
                'closing_date' => $job->closing_date?->toDateString(),
                'requirements' => $job->requirements,
                'benefits' => $job->benefits,
                'status' => $job->status,
                'model' => $job,
                'employer' => $job->employer,
                'employer_profile' => $job->employer->employerProfile,
            ];

            return view('jobs.show', compact('jobData'));
        }

        // For external jobs, we would need to fetch from API or show limited info
        // For now, redirect back with error
        return redirect()->route('jobs.index')->with('error', 'Job not found.');
    }

    /**
     * Show jobs by category
     */
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        return redirect()->route('jobs.index', ['category' => $slug])
            ->with('category_name', $category->name);
    }

    /**
     * Search jobs via AJAX
     */
    public function search(Request $request)
    {
        $params = [
            'search' => $request->get('search'),
            'location' => $request->get('location'),
            'category' => $request->get('category'),
            'limit' => 10,
        ];

        $jobs = $this->jobApiService->fetchJobs($params);

        return response()->json([
            'jobs' => $jobs,
            'total' => count($jobs),
        ]);
    }

    // The following methods are for employer job management
    // They will be moved to EmployerController later

    public function create()
    {
        $this->middleware('role:employer');
        $categories = Category::active()->get();
        return view('jobs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->middleware('role:employer');
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'location' => 'required|string|max:255',
            'job_type' => 'required|in:full-time,part-time,contract,remote,internship',
            'salary_min' => 'nullable|string|max:255',
            'salary_max' => 'nullable|string|max:255',
            'closing_date' => 'nullable|date|after:today',
        ]);

        $job = Job::create([
            'employer_id' => auth()->id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'company_name' => auth()->user()->employerProfile->company_name ?? auth()->user()->name,
            'location' => $request->location,
            'salary_min' => $request->salary_min,
            'salary_max' => $request->salary_max,
            'job_type' => $request->job_type,
            'closing_date' => $request->closing_date,
            'requirements' => $request->requirements ? explode(',', $request->requirements) : null,
            'benefits' => $request->benefits ? explode(',', $request->benefits) : null,
        ]);

        return redirect()->route('employer.jobs.index')
            ->with('success', 'Job posted successfully!');
    }

    public function edit($id)
    {
        $this->middleware('role:employer');
        $job = Job::where('employer_id', auth()->id())->findOrFail($id);
        $categories = Category::active()->get();
        return view('jobs.edit', compact('job', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $this->middleware('role:employer');
        
        $job = Job::where('employer_id', auth()->id())->findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'location' => 'required|string|max:255',
            'job_type' => 'required|in:full-time,part-time,contract,remote,internship',
            'salary_min' => 'nullable|string|max:255',
            'salary_max' => 'nullable|string|max:255',
            'closing_date' => 'nullable|date|after:today',
        ]);

        $job->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'salary_min' => $request->salary_min,
            'salary_max' => $request->salary_max,
            'job_type' => $request->job_type,
            'closing_date' => $request->closing_date,
            'requirements' => $request->requirements ? explode(',', $request->requirements) : null,
            'benefits' => $request->benefits ? explode(',', $request->benefits) : null,
        ]);

        return redirect()->route('employer.jobs.index')
            ->with('success', 'Job updated successfully!');
    }

    public function destroy($id)
    {
        $this->middleware('role:employer');
        $job = Job::where('employer_id', auth()->id())->findOrFail($id);
        $job->delete();

        return redirect()->route('employer.jobs.index')
            ->with('success', 'Job deleted successfully!');
    }
}
