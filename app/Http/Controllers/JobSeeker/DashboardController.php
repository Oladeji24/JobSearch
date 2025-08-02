<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:job_seeker']);
    }

    public function index()
    {
        $user = auth()->user();
        
        // Get dashboard statistics
        $stats = [
            'applications' => $user->applications()->count(),
            'bookmarks' => $user->bookmarks()->count(),
            'resumes' => $user->resumes()->count(),
            'profile_completion' => $this->calculateProfileCompletion($user),
        ];

        // Get recent applications
        $recentApplications = $user->applications()
            ->with(['job', 'job.category'])
            ->latest()
            ->take(5)
            ->get();

        // Get bookmarked jobs
        $bookmarkedJobs = $user->bookmarks()
            ->with(['job', 'job.category'])
            ->latest()
            ->take(5)
            ->get();

        // Get notifications
        $notifications = $user->notifications()
            ->latest()
            ->take(5)
            ->get();

        return view('job-seeker.dashboard', compact(
            'stats', 
            'recentApplications', 
            'bookmarkedJobs', 
            'notifications'
        ));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('job-seeker.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'bio']);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && file_exists(storage_path('app/public/' . $user->avatar))) {
                unlink(storage_path('app/public/' . $user->avatar));
            }

            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $avatarPath;
        }

        $user->update($data);

        return redirect()->route('job-seeker.profile')
            ->with('success', 'Profile updated successfully!');
    }

    public function applications()
    {
        $applications = auth()->user()->applications()
            ->with(['job', 'job.category', 'employer'])
            ->latest()
            ->paginate(10);

        return view('job-seeker.applications', compact('applications'));
    }

    public function bookmarks()
    {
        $bookmarks = auth()->user()->bookmarks()
            ->with(['job', 'job.category'])
            ->latest()
            ->paginate(10);

        return view('job-seeker.bookmarks', compact('bookmarks'));
    }

    public function resumes()
    {
        $resumes = auth()->user()->resumes()
            ->latest()
            ->get();

        return view('job-seeker.resumes', compact('resumes'));
    }

    public function uploadResume(Request $request)
    {
        $request->validate([
            'resume' => 'required|file|mimes:pdf,doc,docx|max:5120', // 5MB max
        ]);

        $user = auth()->user();
        $file = $request->file('resume');
        
        // Store the file
        $filePath = $file->store('resumes', 'public');
        
        // Create resume record
        $resume = $user->resumes()->create([
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'file_type' => $file->getClientOriginalExtension(),
            'file_size' => $file->getSize(),
            'is_primary' => $user->resumes()->count() === 0, // First resume is primary
        ]);

        // TODO: Integrate resume parsing here
        // $this->parseResume($resume);

        return redirect()->route('job-seeker.resumes')
            ->with('success', 'Resume uploaded successfully!');
    }

    public function deleteResume($id)
    {
        $resume = auth()->user()->resumes()->findOrFail($id);
        
        // Delete file from storage
        if (file_exists(storage_path('app/public/' . $resume->file_path))) {
            unlink(storage_path('app/public/' . $resume->file_path));
        }
        
        $resume->delete();

        return redirect()->route('job-seeker.resumes')
            ->with('success', 'Resume deleted successfully!');
    }

    public function makePrimaryResume($id)
    {
        $resume = auth()->user()->resumes()->findOrFail($id);
        $resume->makePrimary();

        return redirect()->route('job-seeker.resumes')
            ->with('success', 'Resume set as primary successfully!');
    }

    public function notifications()
    {
        $notifications = auth()->user()->notifications()
            ->latest()
            ->paginate(15);

        // Mark all as read
        auth()->user()->unreadNotifications->markAsRead();

        return view('job-seeker.notifications', compact('notifications'));
    }

    private function calculateProfileCompletion($user)
    {
        $fields = ['name', 'email', 'phone', 'bio', 'avatar'];
        $completed = 0;
        
        foreach ($fields as $field) {
            if (!empty($user->$field)) {
                $completed++;
            }
        }
        
        // Add resume check
        if ($user->resumes()->count() > 0) {
            $completed++;
            $fields[] = 'resume';
        }
        
        return round(($completed / count($fields)) * 100);
    }
}
