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
        // Create the subjects table
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Subject name (e.g., Math, English)
            $table->string('code')->unique(); // Unique subject code (e.g., MATH101)
            $table->string('block')->nullable(); // Block or class group (optional)
            $table->foreignId('semester_id')->constrained('semesters')->onDelete('cascade'); // References semesters table
            $table->foreignId('prerequisite_id')->nullable()->constrained('subjects')->onDelete('set null'); // Optional prerequisite subject
            $table->decimal('fee', 10, 2)->nullable(); // Subject fee (optional)
            $table->decimal('units', 3, 1)->unsigned(); // Number of units (e.g., 3.0, 1.5)
            $table->integer('year_level')->unsigned(); // Year level the subject belongs to
            
            // **NEW: Assign Course and Professor Directly**
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade'); // Course that the subject belongs to
            $table->foreignId('professor_id')->constrained('professors')->onDelete('cascade'); // Professor assigned to teach this subject
        
            $table->timestamps();
        });
        

        // Create the pivot table for student-subject enrollment
        Schema::create('student_subject', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade'); // Links to students table
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade'); // Links to subjects table
            $table->foreignId('enrollment_id')->constrained('enrollments')->onDelete('cascade'); // Links to enrollments table, if applicable
            $table->decimal('grade', 5, 2)->nullable(); // Grade for the subject (optional)
            $table->enum('status', ['enrolled', 'dropped', 'completed'])->default('enrolled'); // Enrollment status
            $table->timestamps();
        });
        
        // Pivot table for course-subject relationship
        Schema::create('course_subject', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->foreignId('semester_id')->constrained('semesters')->onDelete('cascade'); // Add this if needed
            $table->string('year_level');
            $table->timestamps();
        });
        

        // Pivot table for professor-subject relationship
        Schema::create('professor_subject', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professor_id')->constrained('professors')->onDelete('cascade'); // Links to professors table
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade'); // Links to subjects table
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professor_subject'); // Drop professor-subject pivot table
        Schema::dropIfExists('course_subject');   // Drop course-subject pivot table
        Schema::dropIfExists('student_subject');  // Drop student-subject pivot table
        Schema::dropIfExists('subjects');         // Drop subjects table
    }
};
