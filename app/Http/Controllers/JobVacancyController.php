<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\JobVacancyCreateRequest;
use App\Models\Company;
use App\Models\JobCategory;
use App\Models\JobVacancy;

class JobVacancyController extends Controller
{
    public function index()
    {
        $vacancies = JobVacancy::with(['company', 'jobCategory'])->latest()->paginate(10);
        return view('job-vacancies.index', compact('vacancies'));
    }

    public function archived()
    {
        $vacancies = JobVacancy::onlyTrashed()->with(['company', 'jobCategory'])->latest()->paginate(10);
        return view('job-vacancies.archived', compact('vacancies'));
    }

    public function create()
    {
        $companies = Company::orderBy('name')->get();
        $categories = JobCategory::orderBy('name')->get();
        $types = ['Full-Time', 'Part-Time', 'Remote', 'Hybrid', 'Contract'];

        return view('job-vacancies.create', compact('companies', 'categories', 'types'));
    }
                          
    public function store(JobVacancyCreateRequest $request)
    {
        JobVacancy::create($request->validated());
        return redirect()->route('job-vacancy.index')->with('success', 'Job vacancy created successfully!');
    }

    public function show(string $id)
    {
        $vacancy = JobVacancy::with(['company', 'jobCategory', 'jobApplications.user'])->findOrFail($id);
        return view('job-vacancies.show', compact('vacancy'));
    }

    public function edit(string $id)
    {
        $vacancy = JobVacancy::findOrFail($id);
        $companies = Company::orderBy('name')->get();
        $categories = JobCategory::orderBy('name')->get();
        $types = ['Full-Time', 'Part-Time', 'Remote', 'Hybrid', 'Contract'];

        return view('job-vacancies.edit', compact('vacancy', 'companies', 'categories', 'types'));
    }

    public function update(Request $request, string $id)
    {
        $vacancy = JobVacancy::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|numeric',
            'type' => 'required|string|in:Full-Time,Part-Time,Remote,Hybrid,Contract',
            'jobCategoryId' => 'required|exists:job_categories,id',
            'companyId' => 'required|exists:companies,id',
        ]);

        $vacancy->update($validated);

        return redirect()->route('job-vacancy.index')->with('success', 'Job vacancy updated successfully!');
    }

    public function destroy(string $id)
    {
        $vacancy = JobVacancy::findOrFail($id);
        $vacancy->delete();
        return redirect()->route('job-vacancy.index')->with('success', 'Job vacancy archived successfully!');
    }

    public function restore(string $id)
    {
        $vacancy = JobVacancy::onlyTrashed()->findOrFail($id);
        $vacancy->restore();
        return redirect()->route('job-vacancy.index', ['archived' => 'true'])->with('success', 'Job vacancy restored successfully!');
    }
}