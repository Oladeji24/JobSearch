<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $request->validate([
            'job_id' => 'required|exists:jobs,id',
            'cover_letter' => 'nullable|string|max:2000',
        ]);

        $user = auth()->user();
        $job = \App\Models\Job::findOrFail($request->job_id);

        // Check if user has already applied
        if ($user->hasAppliedTo($job->id)) {
            return redirect()->back()->with('error', 'You have already applied to this job.');
        }

        // Get user's primary resume
        $primaryResume = $user->resumes()->where('is_primary', true)->first();
        
        if (!$primaryResume) {
            return redirect()->back()->with('error', 'Please upload a resume before applying.');
        }

        // Create application
        $application = \App\Models\Application::create([
            'user_id' => $user->id,
            'job_id' => $job->id,
            'employer_id' => $job->employer_id,
            'cover_letter' => $request->cover_letter,
            'resume_path' => $primaryResume->file_path,
        ]);

        // Send notification to employer (optional)
        // $job->employer->notify(new NewJobApplication($application));

        return redirect()->back()->with('success', 'Application submitted successfully!');
    }

    public function destroy($id)
    {
        $application = auth()->user()->applications()->findOrFail($id);
        
        // Only allow withdrawal if status is pending
        if ($application->status !== 'pending') {
            return redirect()->back()->with('error', 'Cannot withdraw this application.');
        }

        $application->delete();

        return redirect()->back()->with('success', 'Application withdrawn successfully.');
    }
}
