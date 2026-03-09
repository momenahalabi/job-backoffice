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
        Schema::create('job_vacancies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            
            // تم التغيير من string إلى text لاستيعاب النصوص الطويلة
            $table->text('description'); 
            
            $table->string('location');
            
            // يفضل تحديد الدقة للكسور العشرية (مثلاً 12 رقم، منها 2 بعد الفاصلة)
            $table->decimal('salary', 12, 2); 
            $table->enum('type', ['Full-time', 'Remote', 'contract', 'Hybrid']);
            $table->timestamps();
            $table->softDeletes();  

            // Relationships
            $table->uuid('jobCategoryId');
            $table->foreign('jobCategoryId')->references('id')->on('job_categories')->onDelete('restrict');
            $table->uuid('companyId');
            $table->foreign('companyId')->references('id')->on('companies')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_vacancies');
    }
};