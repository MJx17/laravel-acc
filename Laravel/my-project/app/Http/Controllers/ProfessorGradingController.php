<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subject;
use App\Models\Student;

class ProfessorGradingController extends Controller
{
    /**
     * Display the list of students enrolled in a specific subject assigned to the professor.
     */
    public function showStudentsForGrading($subjectId)
    {
        $professor = Auth::user();

        // Find the subject and ensure it belongs to the professor
        $subject = Subject::where('id', $subjectId)
            ->where('professor_id', $professor->id)
            ->with('students')
            ->firstOrFail();

        return view('professors.grade_students', compact('subject'));
    }

    /**
     * Update grades for students in the specific subject.
     */
    public function updateGrades(Request $request, $subjectId)
    {
        $professor = Auth::user();

        // Find the subject and ensure it belongs to the professor
        $subject = Subject::where('id', $subjectId)
            ->where('professor_id', $professor->id)
            ->firstOrFail();

        // Validate input
        $request->validate([
            'grades.*' => 'nullable|numeric|min:0|max:100',
        ]);

        // Update grades for each student
        foreach ($request->grades as $studentId => $grade) {
            $subject->students()->updateExistingPivot($studentId, ['grade' => $grade]);
        }

        return back()->with('success', 'Grades updated successfully.');
    }
}
