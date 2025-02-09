<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\CourseSubject;
use App\Models\StudentSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class EnrollmentController extends Controller
{
    // Display a listing of enrollments
    public function index()
    {
        $enrollments = Enrollment::with('student', 'semester', 'course')->paginate(10);
        return view('enrollments.index', compact('enrollments'));
    }

    // Show the form to create a new enrollment
    public function create(Request $request)
    {
        $excludedStudentIds = Enrollment::pluck('student_id')->toArray();
        $students = Student::whereNotIn('id', $excludedStudentIds)->get();
        $courses = Course::all();
        $semesters = Semester::all();
        $subjects = collect(); // Empty collection by default

        if ($request->has(['course_id', 'semester_id', 'year_level'])) {
            $subjects = Subject::where('course_id', $request->course_id)
                ->where('semester_id', $request->semester_id)
                ->where('year_level', $request->year_level)
                ->get();
        }

        return view('enrollments.create', compact('students', 'courses', 'semesters', 'subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'semester_id' => 'required|exists:semesters,id',
            'course_id' => 'required|exists:courses,id',
            'year_level' => 'required|string',
            'subjects' => 'required|array',
            'subjects.*' => 'exists:subjects,id'
        ]);
    
        try {
            DB::beginTransaction(); // Start transaction
    
            // Create enrollment
            $enrollment = Enrollment::create([
                'student_id' => $validated['student_id'],
                'semester_id' => $validated['semester_id'],
                'course_id' => $validated['course_id'],
                'year_level' => $validated['year_level'],
                'subject_ids' => json_encode($validated['subjects']),
            ]);
    
            // Update student status to 'enrolled'
            Student::where('id', $validated['student_id'])->update(['status' => 'enrolled']);
    
            // Insert subjects into student_subjects table
            $studentSubjects = [];
            foreach ($validated['subjects'] as $subject_id) {
                $studentSubjects[] = [
                    'student_id' => $validated['student_id'],
                    'subject_id' => $subject_id,
                    'enrollment_id' => $enrollment->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
    
            // Bulk insert for better performance
            StudentSubject::insert($studentSubjects);
    
            DB::commit(); // Commit transaction
    
            return redirect()->route('enrollments.index')->with('success', 'Enrollment created successfully!');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback in case of an error
            return back()->with('error', 'Failed to create enrollment: ' . $e->getMessage());
        }
    }
    
    // Show the form to edit an enrollment
    public function edit($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $students = Student::all();
        $courses = Course::all();
        $semesters = Semester::all();
        $selectedSubjects = json_decode($enrollment->subjects, true) ?? [];

        $subjects = Subject::where('course_id', $enrollment->course_id)
                           ->where('year_level', $enrollment->year_level)
                           ->where('semester_id', $enrollment->semester_id)
                           ->get();

        return view('enrollments.edit', compact('enrollment', 'students', 'courses', 'semesters', 'subjects', 'selectedSubjects'));
    }

    // Update an enrollment
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'semester_id' => 'required|exists:semesters,id',
            'course_id' => 'required|exists:courses,id',
            'year_level' => 'required|string',
            'subjects' => 'required|array',
            'subjects.*' => 'exists:subjects,id'
        ]);

        $enrollment = Enrollment::findOrFail($id);
        $enrollment->update([
            'student_id' => $validated['student_id'],
            'semester_id' => $validated['semester_id'],
            'course_id' => $validated['course_id'],
            'year_level' => $validated['year_level'],
            'subject_ids' => json_encode($validated['subjects']),
        ]);

        return redirect()->route('enrollments.index')->with('success', 'Enrollment updated successfully!');
    }

    // Delete an enrollment
    public function destroy($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->delete();

        return redirect()->route('enrollments.index')->with('success', 'Enrollment deleted successfully!');
    }

    public function getSubjects(Request $request)
    {
        $query = Subject::where('semester_id', $request->semester_id)
                        ->whereHas('courses', function ($query) use ($request) {
                            $query->where('courses.id', $request->course_id);
                        });
    
        // Apply year_level filter only if it's not "irregular"
        if ($request->year_level !== 'irregular') {
            $query->where('year_level', $request->year_level);
        }
    
        // Fetch subjects and group by year_level
        $subjects = $query->get()->groupBy('year_level');
    
        return response()->json($subjects);
    }
    
    



    
}
