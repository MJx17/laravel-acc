<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use App\Models\Course;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    // Show the form for creating a new professor
    public function create()
    {
        // Fetch all courses
        $courses = Course::all();

        // Pass the courses to the view
        return view('professors.create', compact('courses'));
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
        ]);

        // Create the professor
        $professor = Professor::create($request->only([
            'user_id', 'surname', 'first_name', 'middle_name', 'sex', 'contact_number', 'email', 'designation'
        ]));

        // No department sync needed anymore
        return redirect()->route('professors.index')->with('success', 'Professor created successfully!');
    }

    // Display a listing of the professors
    public function index()
    {
        // Fetch all professors
        $professors = Professor::paginate(10);

        return view('professors.index', compact('professors'));
    }

    // Show the form for editing the specified professor
    public function edit($id)
    {
        $professor = Professor::findOrFail($id);
        $courses = Course::all(); // Assuming you still want courses

        return view('professors.edit', compact('professor', 'courses'));
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
        ]);

        // Find the professor by ID and update
        $professor = Professor::findOrFail($id);
        $professor->update($request->only([
            'user_id', 'surname', 'first_name', 'middle_name', 'sex', 'contact_number', 'email', 'designation'
        ]));

        // No department sync needed anymore
        return redirect()->route('professors.index')->with('updated', 'Professor updated successfully!');
    }

    // Remove the specified professor from the database
    public function destroy($id)
    {
        $professor = Professor::findOrFail($id);
        $professor->delete();

        return redirect()->route('professors.index')->with('deleted', 'Professor deleted successfully!');
    }

    // Show the details of a specific professor
  
    public function subjects($id)
    {
        $professor = Professor::findOrFail($id);
        $subjects = $professor->subjects()->with('students', 'courses')->paginate(10);
        
        return view('professors.subjects', compact('professor', 'subjects'));
    }

    public function show($id)
    {
        $professor = Professor::findOrFail($id);
        
        // Get subjects assigned to the professor with students count and details
        $subjects = $professor->subjects()->withCount('students')->with('students')->get();

        // Shorten day names
        $dayShortcodes = [
            'Monday' => 'M', 'Tuesday' => 'T', 'Wednesday' => 'W',
            'Thursday' => 'Th', 'Friday' => 'F', 'Saturday' => 'Sa', 'Sunday' => 'Su'
        ];

        // Convert JSON days to shortened text
        $subjects->transform(function ($subject) use ($dayShortcodes) {
            // Ensure it's properly decoded
            $daysArray = is_array($subject->days) ? $subject->days : json_decode($subject->days, true);

            // Convert days to short format
            $subject->formatted_days = collect($daysArray)
                ->map(fn($day) => $dayShortcodes[$day] ?? $day)
                ->implode(', ');

            return $subject;
        });

        return view('professors.show', compact('professor', 'subjects'));
    }
    
    
    

}
