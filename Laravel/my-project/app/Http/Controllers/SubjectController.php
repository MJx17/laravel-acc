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
        $courses = Course::all();
        $professors = Professor::with('user')->get();
        $semesters = Semester::all();
        $subjects = [];

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
            'year_level' => 'required|integer',
            'prerequisite_id' => 'nullable|exists:subjects,id',
            'fee' => 'required|numeric|min:0',
            'units' => 'required|numeric|min:0.1|max:10',
            'course_id' => 'required|exists:courses,id',  // Now a direct column, not pivot
            'professor_id' => 'required|exists:professors,id', // Now a direct column, not pivot
        ]);

        Subject::create($validatedData);

        return redirect()->route('subjects.index')->with('success', 'Subject created successfully!');
    }

    // Show the form to edit the subject
    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        $courses = Course::all();
        $professors = Professor::with('user')->get();
        $semesters = Semester::all();
        $subjects = Subject::where('id', '!=', $subject->id)->get(); // Exclude itself from prerequisites

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
            'year_level' => 'required|integer',
            'prerequisite_id' => 'nullable|exists:subjects,id',
            'fee' => 'required|numeric|min:0',
            'units' => 'required|numeric|min:0.1|max:10',
            'course_id' => 'required|exists:courses,id', 
            'professor_id' => 'required|exists:professors,id',
        ]);

        $subject->update($validatedData);

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
        $subject = Subject::with(['course', 'professor', 'semester'])->findOrFail($id);
        return view('subjects.show', compact('subject'));
    }
}
