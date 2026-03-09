<?php

namespace Database\Seeders;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\User;
use App\Models\Resume;
use Illuminate\Database\Seeder;

class DummyJobApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        if (!$user) {
            return;
        }

        // Create a dummy resume first
        $resume = Resume::create([
            'userId' => $user->id,
            'filename' => 'CV_John_Doe.pdf',
            'fileUri' => 'resumes/dummy.pdf',
            'summary' => 'Experienced software engineer.',
            'contactDetails' => 'john@example.com',
            'education' => 'BSc Computer Science',
            'experience' => '5 years at TechCorp',
            'skills' => 'PHP, Laravel, Vue.js',
        ]);

        $vacancies = JobVacancy::limit(5)->get();
        if ($vacancies->isEmpty()) {
            return;
        }

        foreach ($vacancies as $index => $vacancy) {
            $status = ['pending', 'accepted', 'rejected'][$index % 3];
            
            $application = JobApplication::create([
                'userId' => $user->id,
                'jobVacancyId' => $vacancy->id,
                'resumeId' => $resume->id,
                'status' => $status,
                'aiGeneratedScore' => rand(50, 95),
            ]);

            // Archive the last two applications
            if ($index >= 3) {
                $application->delete();
            }
        }
    }
}
