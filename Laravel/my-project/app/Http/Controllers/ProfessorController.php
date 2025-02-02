<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    // Show the form for creating a new professor
    public function create()
    {
        // Fetch all courses and departments
        $courses = Course::all();
        $departments = Department::all();
        
        // Pass the courses and departments to the view
        return view('professors.create', compact('courses', 'departments'));
    }

    // Store a newly created professor in the database
    public function store(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'surname' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'sex' => 'required|string',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|unique:professors',
            'designation' => 'required|string|max:255',
            'department_ids' => 'required|array', // Ensure departments are selected
            'department_ids.*' => 'exists:departments,id', // Ensure department IDs exist
        ]);

        // Create the professor
        $professor = Professor::create($request->only([
            'user_id', 'surname', 'first_name', 'middle_name', 'sex', 'contact_number', 'email', 'designation'
        ]));

        // Attach the selected departments to the professor
        $professor->departments()->sync($request->input('department_ids'));

        return redirect()->route('professors.index')->with('success', 'Professor created successfully!');
    }

    // Display a listing of the professors
    public function index()
    {
        // Fetch all professors with their departments
        $professors = Professor::with('departments')->paginate(10);
        return view('professors.index', compact('professors'));
    }

    // Show the form for editing the specified professor
    public function edit($id)
    {
        $professor = Professor::findOrFail($id);
        $departments = Department::all();
        return view('professors.edit', compact('professor', 'departments'));
    }

    // Update the specified professor in the database
    public function update(Request $request, $id)
    {
        // Validate incoming data
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'surname' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'sex' => 'required|string',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|unique:professors,email,' . $id,
            'designation' => 'required|string|max:255',
            'department_ids' => 'required|array', // Ensure departments are selected
            'department_ids.*' => 'exists:departments,id', // Ensure department IDs exist
        ]);

        // Find the professor by ID and update
        $professor = Professor::findOrFail($id);
        $professor->update($request->only([
            'user_id', 'surname', 'first_name', 'middle_name', 'sex', 'contact_number', 'email', 'designation'
        ]));

        // Sync the selected departments with the professor
        $professor->departments()->sync($request->input('department_ids'));

        return redirect()->route('professors.index')->with('success', 'Professor updated successfully!');
    }

    // Remove the specified professor from the database
    public function destroy($id)
    {
        $professor = Professor::findOrFail($id);
        $professor->departments()->detach(); // Detach related departments
        $professor->delete();

        return redirect()->route('professors.index')->with('success', 'Professor deleted successfully!');
    }

    // Show the details of a specific professor
    public function show($id)
    {
        $professor = Professor::with('departments')->findOrFail($id);
        return view('professors.show', compact('professor'));
    }
}
