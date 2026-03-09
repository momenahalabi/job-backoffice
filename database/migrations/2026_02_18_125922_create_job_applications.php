<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            
            // تصحيح: float يأخذ (إجمالي الخانات، الخانات العشرية) 
            // 8,2 تعني رقم بحد أقصى 999999.99
            $table->float('aiGeneratedScore', 8, 2)->default(0); 
            
            $table->longText('aiGeneratedFeedback')->nullable();
            
            // التعريفات الأساسية للـ UUIDs
            $table->uuid('jobVacancyId');
            $table->uuid('userId');
            $table->uuid('resumeId');

            // العلاقات (Foreign Keys) - تُكتب مرة واحدة فقط
            $table->foreign('jobVacancyId')->references('id')->on('job_vacancies')->onDelete('restrict');
            $table->foreign('userId')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('resumeId')->references('id')->on('resumes')->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};