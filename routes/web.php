<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified','role:admin,company-owner'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // الشركات - تم إضافة ->names('company') لتعريف company.index
    Route::get('/companies/archived', [CompanyController::class, 'archived'])->name('companies.archived');
    Route::patch('/companies/{company}/restore', [CompanyController::class, 'restore'])->name('companies.restore')->withTrashed();
    Route::resource('companies', CompanyController::class)->names('company');

    // طلبات التوظيف
    // طلبات التوظيف
    Route::get('/job-applications/archived', [JobApplicationController::class, 'archived'])->name('application.archived');
    Route::patch('/job-applications/{job_application}/restore', [JobApplicationController::class, 'restore'])->name('application.restore')->withTrashed();
    Route::resource('job-applications', JobApplicationController::class)->names('application');

    // تصنيفات الوظائف - تم إضافة ->names('category') لتعريف category.index
    Route::patch('/job-categories/{job_category}/restore', [JobCategoryController::class, 'restore'])->name('category.restore')->withTrashed();
    Route::resource('job-categories', JobCategoryController::class)->names('category');

    // الوظائف الشاغرة
    Route::get('/job-vacancies/archived', [JobVacancyController::class, 'archived'])->name('job-vacancy.archived');
    Route::patch('/job-vacancies/{job_vacancy}/restore', [JobVacancyController::class, 'restore'])->name('job-vacancy.restore')->withTrashed();
    Route::resource('job-vacancies', JobVacancyController::class)->names('job-vacancy');

    // المستخدمين
    Route::get('/users/archived', [UserController::class, 'archived'])->name('user.archived');
    Route::patch('/users/{user}/restore', [UserController::class, 'restore'])->name('user.restore')->withTrashed();
    Route::resource('users', UserController::class)->names('user');

    // الملف الشخصي
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php'; 