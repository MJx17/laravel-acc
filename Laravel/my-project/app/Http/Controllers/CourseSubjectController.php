<?php

namespace App\Http\Controllers;

use App\Models\CourseSubject;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseSubjectController extends Controller
{
    // Display all course-subject mappings
    public function index()
    {
        // Fetch all course-subject mappings with course and subject relations
        $courseSubjects = CourseSubject::with(['course', 'subject'])->get();
        
        // Group courseSubjects by course
        $groupedCourses = $courseSubjects->groupBy(function ($item) {
            return $item->course->course_name;
        });
        
        return view('course-subjects.index', compact('groupedCourses'));
    }
    
    
    // Link a subject to a course
    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        // Create a new CourseSubject mapping
        $courseSubject = CourseSubject::create($request->all());

        return response()->json(['message' => 'Subject linked to course successfully', 'data' => $courseSubject], 201);
    }

    // Show a specific course-subject mapping
    public function show($id)
    {
        // Get a specific course-subject mapping with relationships
        $courseSubject = CourseSubject::with(['course', 'subject'])->findOrFail($id);
        return response()->json($courseSubject);
    }

    // Edit a course-subject mapping
    public function update(Request $request, $id)
    {
        $courseSubject = CourseSubject::findOrFail($id);

        // Validate request
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        // Update the course-subject mapping
        $courseSubject->update($request->all());

        return response()->json(['message' => 'Course-Subject updated successfully', 'data' => $courseSubject]);
    }

    // Remove a subject from a course
    public function destroy($id)
    {
        $courseSubject = CourseSubject::findOrFail($id);
        $courseSubject->delete();

        return response()->json(['message' => 'Subject removed from course']);
    }
}
