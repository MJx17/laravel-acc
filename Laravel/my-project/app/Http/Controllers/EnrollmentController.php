<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Semester;
use App\Models\Course;
use App\Models\Subject;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    // Display a listing of enrollments
    public function index()
    {
        // Paginate enrollments with related data
        $enrollments = Enrollment::with(['student', 'semester', 'course', 'subjects'])
                                 ->paginate(10); // Adjust the number as needed
    
        return view('enrollments.index', compact('enrollments'));
    }

    // Show the form for creating a new enrollment
    public function create()
    {
        $students = Student::all();
        $semesters = Semester::all();
        $courses = Course::all();
        $subjects = Subject::all(); // Assuming you have subjects to associate

        return view('enrollments.create', compact('students', 'semesters', 'courses', 'subjects'));
    }

    // Store a newly created enrollment in storage
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'semester_id' => 'required|exists:semesters,id',
            'course_id' => 'required|exists:courses,id',
            'year_level' => 'required|integer',
            'subjects' => 'array|required', // Assuming subjects are selected
        ]);

        $enrollment = Enrollment::create([
            'student_id' => $validated['student_id'],
            'semester_id' => $validated['semester_id'],
            'course_id' => $validated['course_id'],
            'year_level' => $validated['year_level'],
        ]);

        // Attach selected subjects to the enrollment
        $enrollment->subjects()->attach($validated['subjects']);

        return redirect()->route('enrollments.index')->with('success', 'Enrollment created successfully!');
    }

    // Show the form for editing the specified enrollment
    public function edit($id)
    {
        $enrollment = Enrollment::with(['student', 'semester', 'course', 'subjects'])->findOrFail($id);
        $students = Student::all();
        $semesters = Semester::all();
        $courses = Course::all();
        $subjects = Subject::all();

        return view('enrollments.edit', compact('enrollment', 'students', 'semesters', 'courses', 'subjects'));
    }

    // Update the specified enrollment in storage
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'semester_id' => 'required|exists:semesters,id',
            'course_id' => 'required|exists:courses,id',
            'year_level' => 'required|integer',
            'subjects' => 'array|required', // Assuming subjects are selected
        ]);

        $enrollment = Enrollment::findOrFail($id);

        $enrollment->update([
            'student_id' => $validated['student_id'],
            'semester_id' => $validated['semester_id'],
            'course_id' => $validated['course_id'],
            'year_level' => $validated['year_level'],
        ]);

        // Sync subjects with the enrollment
        $enrollment->subjects()->sync($validated['subjects']);

        return redirect()->route('enrollments.index')->with('success', 'Enrollment updated successfully!');
    }

    // Remove the specified enrollment from storage
    public function destroy($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->delete();

        return redirect()->route('enrollments.index')->with('success', 'Enrollment deleted successfully!');
    }
}
