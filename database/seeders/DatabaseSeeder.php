<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use App\Models\JobApplication;
use App\Models\Resume;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 1. Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456778'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $filePath = database_path('data/job_data.json');
        if (!file_exists($filePath)) return;

        $jobData = json_decode(file_get_contents($filePath), true);

        // 2. Categories
        if (isset($jobData['jobCategories'])) {
            foreach ($jobData['jobCategories'] as $category) {
                JobCategory::firstOrCreate(['name' => $category]);
            }
        }

        // 3. Companies
        if (isset($jobData['companies'])) {
            foreach ($jobData['companies'] as $company) {
                $companyOwner = User::firstOrCreate([
                    'email' => fake()->unique()->safeEmail(),
                ], [
                    'name' => fake()->name(),
                    'password' => Hash::make('12345678'),
                    'role' => 'company-owner',
                    'email_verified_at' => now(),
                ]);

                Company::firstOrCreate(['name' => $company['name']], [
                    'address' => $company['address'],
                    'industry' => $company['industry'],
                    'website' => $company['website'],
                    'description' => $company['description'] ?? '',
                    'ownerId' => $companyOwner->id,
                ]);
            }
        }

        // 4. Job Vacancies
        if (isset($jobData['jobVacancies'])) {
            foreach ($jobData['jobVacancies'] as $job) {
                $company = Company::where('name', $job['company'])->first();
                $jobCategory = JobCategory::where('name', $job['category'])->first();

                if ($company && $jobCategory) {
                    JobVacancy::firstOrCreate([
                        'title' => $job['title'],
                        'companyId' => $company->id,
                    ], [
                        'description' => $job['description'],
                        'location' => $job['location'],
                        'type' => $job['type'],
                        'salary' => $job['salary'],
                        'jobCategoryId' => $jobCategory->id,
                    ]);
                }
            }
        }

        // 5. Job Applications - إضافة شرط التأكد من وجود المفتاح لتجنب الخطأ
        if (isset($jobData['jobApplications'])) {
            foreach ($jobData['jobApplications'] as $application) {
                $jobVacancy = JobVacancy::inRandomOrder()->first();
                if (!$jobVacancy) continue;

                $applicant = User::firstOrCreate([
                    'email' => fake()->unique()->safeEmail(),
                ], [
                    'name' => fake()->name(),
                    'password' => Hash::make('12345678'),
                    'role' => 'job-seeker',
                    'email_verified_at' => now(),
                ]);

                $resume = Resume::create([
                    'userId' => $applicant->id,
                    'filename' => $application['resume']['filename'] ?? 'resume.pdf',
                    'fileUri' => $application['resume']['fileUri'] ?? '',
                    'contactDetails' => $application['resume']['contactDetails'] ?? '',
                    'summary' => $application['resume']['summary'] ?? '',
                    'skills' => json_encode($application['resume']['skills'] ?? []),
                    'experience' => $application['resume']['experience'] ?? '',
                    'education' => $application['resume']['education'] ?? '',
                ]);

                JobApplication::create([
                    'jobVacancyId' => $jobVacancy->id,
                    'userId' => $applicant->id,
                    'resumeId' => $resume->id,
                    'status' => $application['status'] ?? 'pending',
                    'aiGeneratedScore' => $application['aiGeneratedScore'] ?? 0,
                    'aiGeneratedFeedback' => $application['aiGeneratedFeedback'] ?? '',
                ]);
            }
        }
    }
}