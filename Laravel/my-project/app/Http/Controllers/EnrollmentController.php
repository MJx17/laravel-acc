<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;
use App\Models\Semester;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    // Display a listing of the enrollments
    public function index()
    {
        // Paginate the enrollments
        $enrollments = Enrollment::with('student', 'semester', 'course')->paginate(10); // You can set the number per page
    
        // Pass the paginated result to the view
        return view('enrollments.index', compact('enrollments'));
    }
    

    // Show the form to create a new enrollment
    public function create()
    {
        // Fetch the IDs of students who are already enrolled
        $excludedStudentIds = Enrollment::pluck('student_id')->toArray();

        // Fetch students who are NOT enrolled yet
        $students = Student::whereNotIn('id', $excludedStudentIds)->get();
        
        // Fetch courses and semesters
        $courses = Course::all();
        $semesters = Semester::all();

        return view('enrollments.create', compact('students', 'courses', 'semesters'));
    }

    // Store a newly created enrollment in the database
    public function store(Request $request)
    {
        // Validate the input data
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'semester_id' => 'required|exists:semesters,id',
            'course_id' => 'required|exists:courses,id',
            'year_level' => 'required|string',
        ]);

        // Create the enrollment record
        Enrollment::create($validated);

        return redirect()->route('enrollments.index')->with('success', 'Enrollment created successfully!');
    }

    // Show the form to edit the specified enrollment
    public function edit($id)
    {
        // Find the enrollment to edit
        $enrollment = Enrollment::findOrFail($id);
        $students = Student::all();
        $courses = Course::all();
        $semesters = Semester::all();

        return view('enrollments.edit', compact('enrollment', 'students', 'courses', 'semesters'));
    }

    // Update the specified enrollment in the database
    public function update(Request $request, $id)
    {
        // Validate the input data
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'semester_id' => 'required|exists:semesters,id',
            'course_id' => 'required|exists:courses,id',
            'year_level' => 'required|string',
        ]);

        // Find the enrollment and update it
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->update($validated);

        return redirect()->route('enrollments.index')->with('success', 'Enrollment updated successfully!');
    }

    // Remove the specified enrollment from the database
    public function destroy($id)
    {
        // Find the enrollment and delete it
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->delete();

        return redirect()->route('enrollments.index')->with('success', 'Enrollment deleted successfully!');
    }
}
