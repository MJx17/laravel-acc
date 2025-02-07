<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Course;
use App\Models\Professor;
use App\Models\Semester;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    // Display a listing of subjects
    public function index()
    {
        $subjects = Subject::paginate(10); // Show 10 subjects per page
        return view('subjects.index', compact('subjects'));
    }

    // Show the form to create a new subject
    public function create()
    {
        $courses = Course::all(); // Fetch all available courses
        $professors = Professor::with('user')->get(); // Fetch professors with user information
        $semesters = Semester::all(); // Fetch semesters
        $subjects = []; // Placeholder for prerequisites if needed
    
        return view('subjects.create', compact('courses', 'professors', 'semesters', 'subjects'));
    }

    // Store a newly created subject
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:subjects,code',
            'description' => 'nullable|string',
            'semester_id' => 'required|exists:semesters,id',
            'year_level' => 'required|string',
            'prerequisite_id' => 'nullable|exists:subjects,id',
            'fee' => 'required|numeric|min:0',
            'units' => 'required|numeric|min:0.1|max:10',
            'course_ids' => 'required|array',  // Handle multiple courses as an array
            'course_ids.*' => 'exists:courses,id',  // Each course ID must exist in the courses table
            'professor_id' => 'required|exists:professors,id',
        ]);

        // Create a new subject
        $subject = Subject::create([
            'name' => $validatedData['name'],
            'code' => $validatedData['code'],
            'description' => $validatedData['description'],
            'semester_id' => $validatedData['semester_id'],
            'year_level' => $validatedData['year_level'],
            'prerequisite_id' => $validatedData['prerequisite_id'],
            'fee' => $validatedData['fee'],
            'units' => $validatedData['units'],
            'professor_id' => $validatedData['professor_id'],
        ]);

        // Attach courses via pivot table (course_subject)
        $subject->courses()->attach($validatedData['course_ids']);

        return redirect()->route('subjects.index')->with('success', 'Subject created successfully!');
    }

    // Show the form to edit the subject
    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        $courses = Course::all(); // Fetch all available courses
        $professors = Professor::with('user')->get(); // Fetch professors with user information
        $semesters = Semester::all(); // Fetch semesters
        $subjects = Subject::where('id', '!=', $subject->id)->get(); // Exclude the current subject from prerequisites

        return view('subjects.edit', compact('subject', 'courses', 'professors', 'semesters', 'subjects'));
    }

    // Update the subject
    public function update(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:subjects,code,' . $subject->id,
            'description' => 'nullable|string',
            'semester_id' => 'required|exists:semesters,id',
            'year_level' => 'required|string',
            'prerequisite_id' => 'nullable|exists:subjects,id',
            'fee' => 'required|numeric|min:0',
            'units' => 'required|numeric|min:0.1|max:10',
            'course_ids' => 'required|array',  // Handle multiple courses as an array
            'course_ids.*' => 'exists:courses,id',  // Each course ID must exist in the courses table
            'professor_id' => 'required|exists:professors,id',
        ]);

        // Update the subject
        $subject->update([
            'name' => $validatedData['name'],
            'code' => $validatedData['code'],
            'description' => $validatedData['description'],
            'semester_id' => $validatedData['semester_id'],
            'year_level' => $validatedData['year_level'],
            'prerequisite_id' => $validatedData['prerequisite_id'],
            'fee' => $validatedData['fee'],
            'units' => $validatedData['units'],
            'professor_id' => $validatedData['professor_id'],
        ]);

        // Sync the courses (attach the courses and detach any that aren't selected)
        $subject->courses()->sync($validatedData['course_ids']);

        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully!');
    }

    // Delete the subject
    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return redirect()->route('subjects.index')->with('success', 'Subject deleted successfully!');
    }

    // Display a single subject
    public function show($id)
    {
        $subject = Subject::with(['courses', 'professor', 'semester'])->findOrFail($id); // Make sure to eager load courses
        return view('subjects.show', compact('subject'));
    }
}
