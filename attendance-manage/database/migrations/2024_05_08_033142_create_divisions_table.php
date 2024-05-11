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
        Schema::create('divisions', function (Blueprint $table) {
            $table->foreignId('class_student_id')->constrained('class_students');
            $table->foreignId('admin_id')->constrained('admins');
            $table->foreignId('subject_id')->constrained('subjects');
            $table->foreignId('instructor_id')->constrained('instructors');
            $table->primary(['class_student_id', 'subject_id', 'instructor_id']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('divisions');
    }
};
