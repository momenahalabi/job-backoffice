<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobApplications = \App\Models\JobApplication::with(['user', 'jobVacancy.company'])->paginate(10);

        return view('job-application.index', compact('jobApplications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vacancies = \App\Models\JobVacancy::all();
        $users = \App\Models\User::all(); // Assuming admin can link to a user

        return view('job-application.create', compact('vacancies', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jobVacancyId' => 'required|uuid|exists:job_vacancies,id',
            'userId' => 'required|uuid|exists:users,id',
            'status' => 'required|string|in:pending,accepted,rejected',
        ]);

        \App\Models\JobApplication::create($validated);

        return redirect()->route('application.index')->with('success', 'Job application created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(\App\Models\JobApplication $jobApplication)
    {
        return view('job-application.show', compact('jobApplication'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(\App\Models\JobApplication $jobApplication)
    {
        $vacancies = \App\Models\JobVacancy::all();

        return view('job-application.edit', compact('jobApplication', 'vacancies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, \App\Models\JobApplication $jobApplication)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,accepted,rejected',
            'aiGeneratedScore' => 'nullable|integer',
            'aiGeneratedFeedback' => 'nullable|string',
        ]);

        $jobApplication->update($validated);

        return redirect()->route('application.index')->with('success', 'Job application updated successfully');
    }

    /**
     * Remove the specified resource from storage (Soft Delete).
     */
    public function destroy(\App\Models\JobApplication $jobApplication)
    {
        $jobApplication->delete();

        return redirect()->route('application.index')->with('success', 'Job application archived successfully');
    }

    /**
     * Display archived job applications.
     */
    public function archived()
    {
        $jobApplications = \App\Models\JobApplication::onlyTrashed()->with(['user', 'jobVacancy.company'])->paginate(10);

        return view('job-application.index', compact('jobApplications'))->with('isArchived', true);
    }

    /**
     * Restore an archived job application.
     */
    public function restore(string $id)
    {
        $jobApplication = \App\Models\JobApplication::onlyTrashed()->findOrFail($id);
        $jobApplication->restore();

        return redirect()->route('application.archived')->with('success', 'Job application restored successfully');
    }
}
