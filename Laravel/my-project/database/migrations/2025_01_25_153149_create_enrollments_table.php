<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrollmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade'); // Links to students table
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('set null'); // The course the student is enrolled in
            $table->foreignId('semester_id')->nullable()->constrained('semesters')->onDelete('set null'); // The semester for the enrollment
            $table->enum('year_level', ['1st_year', '2nd_year', '3rd_year', '4th_year', '5th_year', 'irregular']); // Year level of the student
            $table->timestamps(); // To track creation and update times
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enrollments');
    }
}
