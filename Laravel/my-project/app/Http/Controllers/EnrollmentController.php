<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\CourseSubject;
use App\Models\Fee;
use App\Models\Payment;
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
        $fees = Fee::all();
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
                // Calculate total fee as the sum of fee components
            $tuitionFee = $validated['tuition_fee'];
            $labFee = $validated['lab_fee'] ?? 0;
            $miscellaneousFee = $validated['miscellaneous_fee'] ?? 0;
            $otherFee = $validated['other_fee'] ?? 0;
            $discount = $validated['discount'] ?? 0;

            $totalFee = $tuitionFee + $labFee + $miscellaneousFee + $otherFee;

            // Subtract the fixed discount from the total fee
            $discountedTotal = $totalFee - $discount;

            // Use the provided initial payment from the request (or default to 0 if not provided)
            $initialPayment = $validated['initial_payment'] ?? 0;

            // Calculate the remaining balance after deducting the initial payment
            $remainingBalance = $discountedTotal - $initialPayment;

            // Insert fee record and capture the fee
            $fee = Fee::create([
                'enrollment_id'    => $enrollment->id,
                'tuition_fee'      => $tuitionFee,
                'lab_fee'          => $labFee,
                'miscellaneous_fee'=> $miscellaneousFee,
                'other_fee'        => $otherFee,
                'discount'         => $discount,
                'total'            => $totalFee,
                'initial_payment'  => $initialPayment,
            ]);

            // Prepare payment details
            if ($remainingBalance <= 0) {
                // If the initial payment covers (or exceeds) the discounted total fee
                $paymentsData = [
                    'fee_id'            => $fee->id,
                    'prelims_payment'   => 0,
                    'prelims_paid'      => true,
                    'midterms_payment'  => 0,
                    'midterms_paid'     => true,
                    'pre_final_payment' => 0,
                    'pre_final_paid'    => true,
                    'final_payment'     => 0,
                    'final_paid'        => true,
                    'amount_paid'       => $initialPayment,
                    'balance'           => 0,
                    'status'            => 'Paid',
                ];
            } else {
                // Divide the remaining balance into 4 equal installments
                $installment = $remainingBalance / 4;
                $paymentsData = [
                    'fee_id'            => $fee->id,
                    'prelims_payment'   => $installment,
                    'prelims_paid'      => false,
                    'midterms_payment'  => $installment,
                    'midterms_paid'     => false,
                    'pre_final_payment' => $installment,
                    'pre_final_paid'    => false,
                    'final_payment'     => $installment,
                    'final_paid'        => false,
                    'amount_paid'       => $initialPayment,
                    'balance'           => $remainingBalance,
                    'status'            => 'Pending',
                ];
            }




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
    // Fetch enrollment details for the specific student
    $enrollment = Enrollment::with(['student', 'subjects', 'fees', 'fees.payments'])->findOrFail($id);

    // Fee calculations as before
    if ($enrollment->fees) {
        $tuitionFee = $enrollment->fees->tuition_fee ?? 0;
        $labFee = $enrollment->fees->lab_fee ?? 0;
        $miscFee = $enrollment->fees->miscellaneous_fee ?? 0;
        $otherFee = $enrollment->fees->other_fee ?? 0;
        $discount = $enrollment->fees->discount ?? 0;
        $initialPayment = $enrollment->fees->initial_payment ?? 0;

        $totalFees = ($tuitionFee + $labFee + $miscFee + $otherFee - $discount - $initialPayment);
        $installmentAmount = $totalFees / 4;

        $installmentsPaid = 0;
        $remainingPayment = 0;

        if ($enrollment->fees->payments) {
            $payment = $enrollment->fees->payments;
            // Payments logic here (as you had before)
        }

        $amountPaid = $initialPayment + $installmentsPaid;
        $remainingBalance = max($remainingPayment, 0);
    } else {
        $totalFees = 0;
        $installmentAmount = 0;
        $amountPaid = 0;
        $remainingBalance = 0;
    }

    return view('enrollments.fees', compact('enrollment', 'totalFees', 'installmentAmount', 'amountPaid', 'remainingBalance', ));
}

    
    


    
}
