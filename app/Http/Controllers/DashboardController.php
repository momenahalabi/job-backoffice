<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Admin sees EVERYTHING
        if ($user->role === 'admin') {
            $stats = [
                'active_users' => \App\Models\User::where('created_at', '>=', now()->subDays(30))->count(),
                'active_job_postings' => \App\Models\JobVacancy::count(),
                'total_applications' => \App\Models\JobApplication::count(),
            ];

            $mostAppliedJobs = \App\Models\JobVacancy::with('company')
                ->withCount('jobApplications')
                ->orderByDesc('job_applications_count')
                ->limit(5)
                ->get();

            $topConvertingJobs = \App\Models\JobVacancy::withCount('jobApplications')
                ->limit(2)
                ->get()
                ->map(function ($job) {
                    $mockViews = rand(10, 50); 
                    $job->views = $mockViews;
                    $job->conversion_rate = $mockViews > 0 ? ($job->job_applications_count / $mockViews) * 100 : 0;
                    return $job;
                });

            return view('dashboard.index', compact('stats', 'mostAppliedJobs', 'topConvertingJobs'))->with('isAdmin', true);
        }

        // Company Owner sees only THEIR company data
        $company = $user->company;
        if (!$company) {
             return redirect()->route('dashboard')->with('error', 'You must have a company to see the Dashboard statistics.');
        }

        $stats = [
            'active_users' => \App\Models\JobApplication::whereHas('jobVacancy', function($q) use ($company) {
                 $q->where('companyId', $company->id);
            })->distinct('userId')->count(),
            'active_job_postings' => \App\Models\JobVacancy::where('companyId', $company->id)->count(),
            'total_applications' => \App\Models\JobApplication::whereHas('jobVacancy', function($q) use ($company) {
                 $q->where('companyId', $company->id);
            })->count(),
        ];

        $mostAppliedJobs = \App\Models\JobVacancy::where('companyId', $company->id)
            ->withCount('jobApplications')
            ->orderByDesc('job_applications_count')
            ->limit(5)
            ->get();

        $topConvertingJobs = \App\Models\JobVacancy::where('companyId', $company->id)
            ->withCount('jobApplications')
            ->limit(2)
            ->get()
            ->map(function ($job) {
                $mockViews = rand(10, 50); 
                $job->views = $mockViews;
                $job->conversion_rate = $mockViews > 0 ? ($job->job_applications_count / $mockViews) * 100 : 0;
                return $job;
            });

        return view('dashboard.index', compact('stats', 'mostAppliedJobs', 'topConvertingJobs'))->with('isAdmin', false);
    }
}
