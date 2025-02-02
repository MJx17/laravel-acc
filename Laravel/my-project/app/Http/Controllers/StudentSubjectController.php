<?php

namespace App\Http\Controllers;

use App\Models\StudentSubject;
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
}
