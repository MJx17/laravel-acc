<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\CourseSubject;
use App\Models\Fee;
use App\Models\StudentSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class EnrollmentController extends Controller
{
    // Display a listing of enrollments
    public function index()
    {
        $enrollments = Enrollment::with('student', 'semester', 'course')->paginate(10);
        return view('enrollments.index', compact('enrollments'));
    }

    // Show the form to create a new enrollment
    public function create(Request $request)
    {
        $excludedStudentIds = Enrollment::pluck('student_id')->toArray();
        $students = Student::whereNotIn('id', $excludedStudentIds)->get();
        $courses = Course::all();
        $semesters = Semester::all();
        $subjects = collect(); // Empty collection by default

        if ($request->has(['course_id', 'semester_id', 'year_level'])) {
            $subjects = Subject::where('course_id', $request->course_id)
                ->where('semester_id', $request->semester_id)
                ->where('year_level', $request->year_level)
                ->get();
        }

        return view('enrollments.create', compact('students', 'courses', 'semesters', 'subjects'));
    }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'student_id' => 'required|exists:students,id',
    //         'semester_id' => 'required|exists:semesters,id',
    //         'course_id' => 'required|exists:courses,id',
    //         'year_level' => 'required|string',
    //         'subjects' => 'required|array',
    //         'subjects.*' => 'exists:subjects,id',
    //         'category'  => 'required|string'
    //     ]);
    
    //     try {
    //         DB::beginTransaction(); // Start transaction
    
    //         // Create enrollment
    //         $enrollment = Enrollment::create([
    //             'student_id' => $validated['student_id'],
    //             'semester_id' => $validated['semester_id'],
    //             'course_id' => $validated['course_id'],
    //             'year_level' => $validated['year_level'],
    //             'subject_ids' => json_encode($validated['subjects']),
    //             'category'  => $validated['category'],
    //         ]);
    
    //         // Update student category to 'enrolled'
    //         Student::where('id', $validated['student_id'])->update(['status' => 'enrolled']);
    
    //         // Insert subjects into student_subjects table
    //         $studentSubjects = [];
    //         foreach ($validated['subjects'] as $subject_id) {
    //             $studentSubjects[] = [
    //                 'student_id' => $validated['student_id'],
    //                 'subject_id' => $subject_id,
    //                 'enrollment_id' => $enrollment->id,
    //                 'created_at' => now(),
    //                 'updated_at' => now(),
    //             ];
    //         }
    
    //         // Bulk insert for better performance
    //         StudentSubject::insert($studentSubjects);
    
    //         DB::commit(); // Commit transaction
    
    //         return redirect()->route('enrollments.index')->with('success', 'Enrollment created successfully!');
    //     } catch (\Exception $e) {
    //         DB::rollBack(); // Rollback in case of an error
    //         return back()->with('error', 'Failed to create enrollment: ' . $e->getMessage());
    //     }
    // }




//     public function store(Request $request)
// {
//     $validated = $request->validate([
//         'student_id' => 'required|exists:students,id',
//         'semester_id' => 'required|exists:semesters,id',
//         'course_id' => 'required|exists:courses,id',
//         'year_level' => 'required|string',
//         'subjects' => 'required|array',
//         'subjects.*' => 'exists:subjects,id',
//         'category'  => 'required|string',
//         'tuition_fee' => 'required|numeric',
//         'lab_fee' => 'nullable|numeric',
//         'miscellaneous_fee' => 'nullable|numeric',
//         'other_fee' => 'nullable|numeric',
//         'discount' => 'nullable|numeric'
//     ]);

//     try {
//         DB::beginTransaction(); // Start transaction

//         // Create enrollment
//         $enrollment = Enrollment::create([
//             'student_id' => $validated['student_id'],
//             'semester_id' => $validated['semester_id'],
//             'course_id' => $validated['course_id'],
//             'year_level' => $validated['year_level'],
//             'subject_ids' => json_encode($validated['subjects']),
//             'category'  => $validated['category'],
//         ]);

//         // Update student status to 'enrolled'
//         Student::where('id', $validated['student_id'])->update(['status' => 'enrolled']);

//         // Insert subjects into student_subjects table
//         $studentSubjects = [];
//         foreach ($validated['subjects'] as $subject_id) {
//             $studentSubjects[] = [
//                 'student_id' => $validated['student_id'],
//                 'subject_id' => $subject_id,
//                 'enrollment_id' => $enrollment->id,
//                 'created_at' => now(),
//                 'updated_at' => now(),
//             ];
//         }

//         StudentSubject::insert($studentSubjects); // Bulk insert

//         // Insert fees into students_fees table
//         Fee::create([
//             'enrollment_id' => $enrollment->id,
//             'tuition_fee' => $validated['tuition_fee'],
//             'lab_fee' => $validated['lab_fee'] ?? 0,
//             'miscellaneous_fee' => $validated['miscellaneous_fee'] ?? 0,
//             'other_fee' => $validated['other_fee'] ?? 0,
//             'discount' => $validated['discount'] ?? 0,
//             'total' => ($validated['tuition_fee'] + ($validated['lab_fee'] ?? 0) + 
//             ($validated['miscellaneous_fee'] ?? 0) + ($validated['other_fee'] ?? 0)) - 
//            ($validated['discount'] ?? 0),
//         ]);

//         DB::commit(); // Commit transaction

//         return redirect()->route('enrollments.index')->with('success', 'Enrollment created successfully with fees!');
//     } catch (\Exception $e) {
//         DB::rollBack(); // Rollback in case of an error
//         return back()->with('error', 'Failed to create enrollment: ' . $e->getMessage());
//     }
// }


public function store(Request $request)
{
    $validated = $request->validate([
        'student_id' => 'required|exists:students,id',
        'semester_id' => 'required|exists:semesters,id',
        'course_id' => 'required|exists:courses,id',
        'year_level' => 'required|string',
        'subjects' => 'required|array',
        'subjects.*' => 'exists:subjects,id',
        'category'  => 'required|string',
        'tuition_fee' => 'required|numeric',
        'lab_fee' => 'nullable|numeric',
        'miscellaneous_fee' => 'nullable|numeric',
        'other_fee' => 'nullable|numeric',
        'discount' => 'nullable|numeric'
    ]);

    try {
        DB::beginTransaction(); // Start transaction

        // Create enrollment
        $enrollment = Enrollment::create([
            'student_id' => $validated['student_id'],
            'semester_id' => $validated['semester_id'],
            'course_id' => $validated['course_id'],
            'year_level' => $validated['year_level'],
            'subject_ids' => json_encode($validated['subjects']),
            'category'  => $validated['category'],
        ]);

        // Update student status to 'enrolled'
        Student::where('id', $validated['student_id'])->update(['status' => 'enrolled']);

        // Insert subjects into student_subjects table
        $studentSubjects = [];
        foreach ($validated['subjects'] as $subject_id) {
            $studentSubjects[] = [
                'student_id' => $validated['student_id'],
                'subject_id' => $subject_id,
                'enrollment_id' => $enrollment->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        StudentSubject::insert($studentSubjects); // Bulk insert

        // Calculate total fee and initial payment
        $tuitionFee = $validated['tuition_fee'];
        $labFee = $validated['lab_fee'] ?? 0;
        $miscellaneousFee = $validated['miscellaneous_fee'] ?? 0;
        $otherFee = $validated['other_fee'] ?? 0;
        $discount = $validated['discount'] ?? 0;

        $totalFee = $tuitionFee + $labFee + $miscellaneousFee + $otherFee;
        $netFee = $totalFee - $discount;

        // Set initial payment as 25% of the total fee (or any other business rule)
        $initialPayment = $netFee * 0.25; // Example: 25% as initial payment

        // Insert fees into students_fees table
        Fee::create([
            'enrollment_id' => $enrollment->id,
            'tuition_fee' => $tuitionFee,
            'lab_fee' => $labFee,
            'miscellaneous_fee' => $miscellaneousFee,
            'other_fee' => $otherFee,
            'discount' => $discount,
            'total' => $totalFee,
            'initial_payment' => $initialPayment, // Add initial payment field
        ]);

        // Insert payment details (divide total fee into four installments)
        $paymentsData = [
            'enrollment_id' => $enrollment->id,
            'prelims_payment' => $netFee / 4,
            'prelims_paid' => false,
            'midterms_payment' => $netFee / 4,
            'midterms_paid' => false,
            'pre_final_payment' => $netFee / 4,
            'pre_final_paid' => false,
            'final_payment' => $netFee / 4,
            'final_paid' => false,
            'amount_paid' => $initialPayment,
            'balance' => $netFee - $initialPayment,
            'status' => 'Pending',
        ];

        Payment::create($paymentsData); // Insert the payment record

        DB::commit(); // Commit transaction

        return redirect()->route('enrollments.index')->with('success', 'Enrollment created successfully with fees and payment schedule!');
    } catch (\Exception $e) {
        DB::rollBack(); // Rollback in case of an error
        return back()->with('error', 'Failed to create enrollment: ' . $e->getMessage());
    }
}



    // Show the form to edit an enrollment
    public function edit($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $students = Student::all();
        $courses = Course::all();
        $semesters = Semester::all();
        $selectedSubjects = json_decode($enrollment->subjects, true) ?? [];

        $subjects = Subject::where('course_id', $enrollment->course_id)
                           ->where('year_level', $enrollment->year_level)
                           ->where('semester_id', $enrollment->semester_id)
                           ->get();

        return view('enrollments.edit', compact('enrollment', 'students', 'courses', 'semesters', 'subjects', 'selectedSubjects'));
    }

    // Update an enrollment
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'semester_id' => 'required|exists:semesters,id',
            'course_id' => 'required|exists:courses,id',
            'year_level' => 'required|string',
            'subjects' => 'required|array',
            'subjects.*' => 'exists:subjects,id',
            'category'  => 'required|string'
        ]);

        $enrollment = Enrollment::findOrFail($id);
        $enrollment->update([
            'student_id' => $validated['student_id'],
            'semester_id' => $validated['semester_id'],
            'course_id' => $validated['course_id'],
            'year_level' => $validated['year_level'],
            'subject_ids' => json_encode($validated['subjects']),
            'category'  => $validated['category'],
        ]);

        return redirect()->route('enrollments.index')->with('success', 'Enrollment updated successfully!');
    }

    // Delete an enrollment
    public function destroy($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->delete();

        return redirect()->route('enrollments.index')->with('success', 'Enrollment deleted successfully!');
    }

    public function getSubjects(Request $request)
    {
        $query = Subject::where('semester_id', $request->semester_id)
                        ->whereHas('courses', function ($query) use ($request) {
                            $query->where('courses.id', $request->course_id);
                        });
    
        // Apply year_level filter only if it's not "irregular"
        if ($request->year_level !== 'irregular') {
            $query->where('year_level', $request->year_level);
        }
    
        // Fetch subjects and group by year_level
        $subjects = $query->get()->groupBy('year_level');
    
        return response()->json($subjects);
    }
    
    
    // public function fees($id)
    // {
    //     // Eager load the related student, subjects, and fees
    //     $enrollment = Enrollment::with(['student', 'subjects', 'fees'])->findOrFail($id);
        
    //     // Compute total fees dynamically
    //     $totalFees = $enrollment->fees ? 
    //         ($enrollment->fees->tuition_fee + 
    //         $enrollment->fees->lab_fee + 
    //         $enrollment->fees->miscellaneous_fee + 
    //         $enrollment->fees->other_fee) - 
    //         $enrollment->fees->discount 
    //         : 0;

    //     return view('enrollments.fees', compact('enrollment', 'totalFees'));
    // }

public function fees($id)
{
    $enrollment = Enrollment::with(['student', 'subjects', 'fees', 'payments'])->findOrFail($id);

    // Compute total fees dynamically, including initial payment
    $totalFees = $enrollment->fees ? 
        ($enrollment->fees->tuition_fee + 
        $enrollment->fees->lab_fee + 
        $enrollment->fees->miscellaneous_fee + 
        $enrollment->fees->other_fee) - 
        $enrollment->fees->discount 
        : 0;

    // Compute total amount paid dynamically (including initial payment)
    $amountPaid = $enrollment->fees->initial_payment ?? 0; // Include initial payment
    if ($enrollment->payments) {
        $amountPaid += (
            $enrollment->payments->prelims_payment +
            $enrollment->payments->midterms_payment +
            $enrollment->payments->pre_final_payment +
            $enrollment->payments->final_payment
        );
    }

    // Compute remaining balance dynamically
    $remainingBalance = $totalFees - $amountPaid;

    return view('enrollments.fees', compact('enrollment', 'totalFees', 'amountPaid', 'remainingBalance'));
}

    


    
}
