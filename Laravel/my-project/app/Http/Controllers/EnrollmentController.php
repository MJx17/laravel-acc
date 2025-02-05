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
    public function create(Request $request)
    {
        // Define excluded student IDs by checking which students already have an enrollment
        $excludedStudentIds = Enrollment::pluck('student_id')->toArray();
    
        // Define excluded course IDs and subject IDs (assuming you have a similar logic for courses and subjects)
        $excludedCourseIds = Enrollment::pluck('course_id')->toArray();
        $excludedSubjectIds = Enrollment::pluck('subject_id')->toArray();
    
        // Fetch students who are NOT enrolled (their student_id does not exist in enrollments)
        $students = Student::whereNotIn('id', $excludedStudentIds)->get();
    
        // Filter subjects based on the selected semester, course, and year level if provided
        $subjects = Subject::query();
    
        // Filter by course, semester, and year level if provided in the request
        if ($request->has('course_id')) {
            $subjects = $subjects->where('course_id', $request->course_id);
        }
        if ($request->has('semester_id')) {
            $subjects = $subjects->where('semester_id', $request->semester_id);
        }
        if ($request->has('year_level')) {
            $subjects = $subjects->where('year_level', $request->year_level);
        }
    
        // Fetch the filtered subjects
        $subjects = $subjects->get();
    
        // Fetch all semesters and courses
        $semesters = Semester::all();
        $courses = Course::all();
    
        // Check if the form is submitted (POST request)
        if ($request->isMethod('post')) {
            // Enroll the student (assuming student_id, course_id, subject_id are passed in request)
            $student = Student::find($request->student_id);
    
            if ($student) {
                // Enroll the student by creating an Enrollment record
                Enrollment::create([
                    'student_id' => $student->id,
                    'course_id' => $request->course_id,
                    'subject_id' => $request->subject_id,
                    'semester_id' => $request->semester_id,
                    'year_level' => $request->year_level
                ]);
    
                // Update the student's status to "enrolled"
                $student->status = 'enrolled';
                $student->save();
            }
        }
    
        // Return view with required data
        return view('enrollments.create', compact('students', 'semesters', 'courses', 'subjects', 'excludedStudentIds', 'excludedCourseIds', 'excludedSubjectIds'));
    }
    
    
    

    public function store(Request $request)
    {
        // Validation rules
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'semester_id' => 'required|exists:semesters,id',
            'course_id' => 'required|exists:courses,id',
            'year_level' => 'required|integer',
            'subjects' => 'array|required', // Ensure subjects are selected
        ]);
    
        // Check if the student is already enrolled in the selected semester and course
        $existingEnrollment = Enrollment::where('student_id', $validated['student_id'])
                                        ->where('semester_id', $validated['semester_id'])
                                        ->where('course_id', $validated['course_id'])
                                        ->exists();
    
        if ($existingEnrollment) {
            return redirect()->back()->withErrors(['student_id' => 'This student is already enrolled in the selected semester and course.']);
        }
    
        // Create the enrollment
        $enrollment = Enrollment::create([
            'student_id' => $validated['student_id'],
            'semester_id' => $validated['semester_id'],
            'course_id' => $validated['course_id'],
            'year_level' => $validated['year_level'],
        ]);
    
        // Attach selected subjects to the enrollment
        $enrollment->subjects()->attach($validated['subjects']);
    
        // Update student status to "enrolled"
        Student::where('id', $validated['student_id'])->update(['status' => 'enrolled']);
    
        return redirect()->route('enrollments.index')->with('success', 'Enrollment created successfully!');
    }
    

    // Show the form for editing the specified enrollment
    public function edit($id, Request $request)
    {
        $enrollment = Enrollment::with(['student', 'semester', 'course', 'subjects'])->findOrFail($id);
        
        // Fetch students who are enrolled or have an enrollment
        $students = Student::where('status', 'enrolled')
                           ->orWhereHas('enrollments')
                           ->get();

        $semesters = Semester::all();
        $courses = Course::all();
        $subjects = Subject::all();

        // Filter subjects based on selected semester, course, and year level if provided
        if ($request->has('semester_id') && $request->has('course_id') && $request->has('year_level')) {
            $subjects = Subject::where('semester_id', $request->semester_id)
                               ->where('course_id', $request->course_id)
                               ->where('year_level', $request->year_level)
                               ->get();
        }

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
            'subjects' => 'array|required', // Ensure subjects are selected
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
        $studentId = $enrollment->student_id;

        $enrollment->delete();

        // Check if the student has other enrollments
        $hasOtherEnrollments = Enrollment::where('student_id', $studentId)->exists();

        // If no other enrollments exist, update student status to "not enrolled"
        if (!$hasOtherEnrollments) {
            Student::where('id', $studentId)->update(['status' => 'not enrolled']);
        }

        return redirect()->route('enrollments.index')->with('success', 'Enrollment deleted successfully!');
    }
}
