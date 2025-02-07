<?php

namespace App\Http\Controllers;

use App\Models\StudentSubject;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentSubjectController extends Controller
{
    public function store(Request $request)
    {
        // Assuming you're storing new enrollment data (status and grade)
        $studentSubject = StudentSubject::create($request->all());

        return response()->json($studentSubject, 201);
    }

    public function updateGrade(Request $request, $id)
    {
        $studentSubject = StudentSubject::findOrFail($id);
        $studentSubject->grade = $request->input('grade');
        $studentSubject->save();

        return response()->json($studentSubject);
    }

    public function delete($id)
    {
        $studentSubject = StudentSubject::findOrFail($id);
        $studentSubject->delete();

        return response()->json(['message' => 'Enrollment removed']);
    }

    public function show($studentId)
    {
        // Fetch the student with their enrolled subjects
        $student = Student::with(['subjects' => function($query) {
            $query->addSelect('subjects.id', 'subjects.name', 'subjects.code')
                  ->withPivot('status', 'grade'); // Including the pivot data (status, grade)
        }])->findOrFail($studentId);
    
        return view('student_subject.subjects', compact('student'));
    }

    public function edit($studentId, )
{
    // Fetch the student and their enrolled subjects with pivot data
    $student = Student::with(['subjects' => function($query) {
        $query->addSelect('subjects.id', 'subjects.name', 'subjects.code')
              ->withPivot('status', 'grade');
    }])->findOrFail($studentId);

    // Pass the student data to the view for editing
    return view('student_subject.edit', compact('student'));
}

public function update(Request $request, $studentId)
{
    // Validate the input
    $request->validate([
        'subjects.*.status' => 'required|string',
        'subjects.*.grade' => 'nullable|string',
    ]);

    // Loop through the subjects and update the pivot data
    foreach ($request->subjects as $subjectId => $data) {
        $studentSubject = StudentSubject::where('student_id', $studentId)
                                        ->where('subject_id', $subjectId)
                                        ->first();

        if ($studentSubject) {
            $studentSubject->status = $data['status'];
            $studentSubject->grade = $data['grade'] ?? null; // Grade can be optional
            $studentSubject->save();
        }
    }

    // Redirect back to the student subjects page with a success message
    return redirect()->route('student_subject.subjects', $studentId)
                     ->with('success', 'Subjects updated successfully.');
}

    
}
