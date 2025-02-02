<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();  // Auto-incrementing ID
            $table->string('course_code');  // Course code (e.g., CS101)
            $table->string('course_name');  // Course name (e.g., Computer Science 101)
            $table->text('description')->nullable();  // Optional course description
            $table->integer('units')->default(3);  // Number of units for the course
            $table->string('major');  
            $table->timestamps();  // Created and updated timestamps
            $table->string('major')->nullable();
            
            // Adding department_id to relate courses to departments
            $table->unsignedBigInteger('department_id')->nullable(); // Foreign key reference to departments table
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
