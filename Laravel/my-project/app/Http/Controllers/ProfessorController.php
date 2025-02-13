<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    // Show the form for creating a new professor
    public function create()
    {
        $existingProfessors = Professor::pluck('user_id'); // Get all professor user IDs
        $users = User::role('professor')
                    ->whereNotIn('id', $existingProfessors) // Exclude existing professors
                    ->get();
        
        $courses = Course::all();
    
        return view('professors.create', compact('users', 'courses'));
    }
    

    public function getProfessors()
    {
        $professors = User::role('professor')->get(); // Use Spatie's role() method

        if ($professors->isEmpty()) {
            return response()->json([
                'message' => 'No professors found'
            ], 404);
        }

        return response()->json([
            'professors' => $professors
        ], 200);
    }

    // Store a newly created professor in the database
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id', function ($attribute, $value, $fail) {
                if (!User::where('id', $value)->where('role', 'professor')->exists()) {
                    $fail('The selected user is not a professor.');
                }
            }],
            'surname' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'sex' => 'required|string',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|unique:professors',
            'designation' => 'required|string|max:255',
        ]);

        Professor::create($request->only([
            'user_id', 'surname', 'first_name', 'middle_name', 'sex', 'contact_number', 'email', 'designation'
        ]));

        return redirect()->route('professors.index')->with('success', 'Professor created successfully!');
    }

    // Display a listing of the professors
    public function index()
    {
        $professors = Professor::paginate(10);
        return view('professors.index', compact('professors'));
    }

    // Show the form for editing the specified professor
    public function edit($id)
    {
        $professor = Professor::findOrFail($id);
        $users = User::where('role', 'professor')->get(); // Fetch only professors
        $courses = Course::all();

        return view('professors.edit', compact('professor', 'users', 'courses'));
    }

    // Update the specified professor in the database
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id', function ($attribute, $value, $fail) {
                if (!User::where('id', $value)->where('role', 'professor')->exists()) {
                    $fail('The selected user is not a professor.');
                }
            }],
            'surname' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'sex' => 'required|string',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|unique:professors,email,' . $id,
            'designation' => 'required|string|max:255',
        ]);

        $professor = Professor::findOrFail($id);
        $professor->update($request->only([
            'user_id', 'surname', 'first_name', 'middle_name', 'sex', 'contact_number', 'email', 'designation'
        ]));

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
    public function show($professor_id)
    {
        $professor = Professor::findOrFail($professor_id);
        $subjects = $professor->subjects()->withCount('students')->with('students')->get();

        $dayShortcodes = [
            'Monday' => 'M', 'Tuesday' => 'T', 'Wednesday' => 'W',
            'Thursday' => 'Th', 'Friday' => 'F', 'Saturday' => 'Sa', 'Sunday' => 'Su'
        ];

        $subjects->transform(function ($subject) use ($dayShortcodes) {
            $daysArray = is_array($subject->days) ? $subject->days : json_decode($subject->days, true);
            $subject->formatted_days = collect($daysArray)
                ->map(fn($day) => $dayShortcodes[$day] ?? $day)
                ->implode(', ');

            return $subject;
        });

        return view('professors.show', compact('professor', 'subjects'));
    }

    public function subjects($id)
    {
        $professor = Professor::findOrFail($id);
        $subjects = $professor->subjects()->with('students', 'courses')->paginate(10);

        return view('professors.subjects', compact('professor', 'subjects'));
    }
}
