<?php

namespace App\Http\Controllers;

use App\Models\CourseSubject;
use App\Models\Course;
use App\Models\Subject;
use Illuminate\Http\Request;

class CourseSubjectController extends Controller
{
    // Display all course-subject mappings
    public function index()
    {
        // Fetch all course-subject mappings with course and subject relations
        $courseSubjects = CourseSubject::with(['course', 'subject'])->get();
        
        // Group by course_code instead of course_name
        $groupedCourses = $courseSubjects->groupBy(function ($item) {
            return $item->course->course_code;
        });
        
        return view('course-subjects.index', compact('groupedCourses'));
    }
    
    // Show form to assign subjects to a course
    public function create()
    {
        $courses = Course::all();
        $subjects = Subject::all();
        
        return view('course-subjects.create', compact('courses', 'subjects'));
    }

    // Show edit form with pre-selected subjects
    public function edit($course_id)
    {
        $course = Course::findOrFail($course_id);
        $subjects = Subject::all();

        // Get already assigned subjects for this course
        $assignedSubjects = CourseSubject::where('course_id', $course_id)
                                         ->pluck('subject_id')
                                         ->toArray();

        return view('course-subjects.edit', compact('course', 'subjects', 'assignedSubjects'));
    }

    // Store subjects linked to a course
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'subject_ids' => 'required|array',
            'subject_ids.*' => 'exists:subjects,id',
        ]);

        // Remove existing subjects for the course to avoid duplicates
        CourseSubject::where('course_id', $request->course_id)->delete();

        // Assign new subjects
        foreach ($request->subject_ids as $subjectId) {
            CourseSubject::create([
                'course_id' => $request->course_id,
                'subject_id' => $subjectId
            ]);
        }

        return redirect()->route('course-subjects.index')->with('success', 'Subjects assigned successfully.');
    }

    // Update subject assignments for a course
    public function update(Request $request, $course_id)
    {
        $request->validate([
            'subject_ids' => 'required|array',
            'subject_ids.*' => 'exists:subjects,id',
        ]);

        // Remove old subjects
        CourseSubject::where('course_id', $course_id)->delete();

        // Assign new subjects
        foreach ($request->subject_ids as $subjectId) {
            CourseSubject::create([
                'course_id' => $course_id,
                'subject_id' => $subjectId
            ]);
        }

        return redirect()->route('course-subjects.index')->with('success', 'Course subjects updated successfully.');
    }

    // Remove a specific subject from a course
    public function destroy($course_id, $subject_id)
    {
        CourseSubject::where('course_id', $course_id)
                     ->where('subject_id', $subject_id)
                     ->delete();
    
        return redirect()->route('course-subjects.index')->with('success', 'Subject removed from course.');
    }
}
