<?php
namespace App\Http\Controllers;

use App\Models\ProfessorSubject;
use Illuminate\Http\Request;

class ProfessorSubjectController extends Controller
{
    public function store(Request $request)
    {
        $professorSubject = ProfessorSubject::create($request->all());

        return response()->json($professorSubject, 201);
    }

    public function delete($id)
    {
        $professorSubject = ProfessorSubject::findOrFail($id);
        $professorSubject->delete();

        return response()->json(['message' => 'Professor removed from subject']);
    }
}
