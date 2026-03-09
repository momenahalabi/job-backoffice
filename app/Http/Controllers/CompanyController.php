<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Models\Company;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::with('owner')->latest()->paginate(10);

        return view('company.index', compact('companies'));
    }

    public function archived()
    {
        $companies = Company::onlyTrashed()->with('owner')->latest()->paginate(10);

        return view('company.archived', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $industries = ['Technology', 'Finance', 'Healthcare', 'Education'];

        return view('company.create', compact('industries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyCreateRequest $request)
    {
        DB::transaction(function () use ($request) {
            // 1. Create the Owner User
            $owner = User::create([
                'name' => $request->owner_name,
                'email' => $request->owner_email,
                'password' => Hash::make($request->owner_password),
                'role' => 'company-owner',
            ]);

            // 2. Create the Company linked to the owner
            Company::create([
                'name' => $request->name,
                'address' => $request->address,
                'industry' => $request->industry,
                'website' => $request->website,
                'description' => $request->description,
                'ownerId' => $owner->id,
            ]);
        });

        return redirect()->route('company.index')->with('success', 'Company and owner created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $company = Company::with(['owner', 'jobVacancies'])->findOrFail($id);

        $applications = JobApplication::with(['user', 'jobVacancy'])
            ->whereIn('jobVacancyId', $company->jobVacancies->pluck('id'))
            ->latest()
            ->get();

        return view('company.show', compact('company', 'applications'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $company = Company::with('owner')->findOrFail($id);
        $industries = ['Technology', 'Finance', 'Healthcare', 'Education'];

        return view('company.edit', compact('company', 'industries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyUpdateRequest $request, string $id)
    {
        $company = Company::findOrFail($id);
        $owner = User::findOrFail($company->ownerId);

        DB::transaction(function () use ($request, $company, $owner) {
            // 1. Update Owner
            $owner->update([
                'name' => $request->owner_name,
                'email' => $request->owner_email,
            ]);

            if ($request->filled('owner_password')) {
                $owner->update([
                    'password' => Hash::make($request->owner_password),
                ]);
            }

            // 2. Update Company
            $company->update([
                'name' => $request->name,
                'address' => $request->address,
                'industry' => $request->industry,
                'website' => $request->website,
                'description' => $request->description,
            ]);
        });

        return redirect()->route('company.index')->with('success', 'Company and owner updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return redirect()->route('company.index')->with('success', 'Company archived successfully!');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(string $id)
    {
        $company = Company::onlyTrashed()->findOrFail($id);
        $company->restore();

        return redirect()->route('company.index', ['archived' => 'true'])->with('success', 'Company restored successfully!');
    }
}
