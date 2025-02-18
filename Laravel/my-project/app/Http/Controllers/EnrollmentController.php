<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\Payment;
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


    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'semester_id' => 'required|exists:semesters,id',
            'course_id' => 'required|exists:courses,id',
            'year_level' => 'required|string',
            'subjects' => 'required|array',
            'subjects.*' => 'exists:subjects,id',
            'category' => 'required|string',
            'tuition_fee' => 'required|numeric',
            'lab_fee' => 'nullable|numeric',
            'miscellaneous_fee' => 'nullable|numeric',
            'other_fee' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'initial_payment' => 'required|numeric',
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
                'category' => $validated['category'],
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
            $tuitionFee = (float)$validated['tuition_fee'];
            $labFee = (float)($validated['lab_fee'] ?? 0);
            $miscellaneousFee = (float)($validated['miscellaneous_fee'] ?? 0);
            $otherFee = (float)($validated['other_fee'] ?? 0);
            $discount = (float)($validated['discount'] ?? 0);
            $initialPayment = (float)$validated['initial_payment'];
    
            $totalFee = $tuitionFee + $labFee + $miscellaneousFee + $otherFee - $discount - $initialPayment;
    
            // Insert fees into students_fees table
            $fee = Fee::create([
                'enrollment_id' => $enrollment->id,
                'tuition_fee' => $tuitionFee,
                'lab_fee' => $labFee,
                'miscellaneous_fee' => $miscellaneousFee,
                'other_fee' => $otherFee,
                'discount' => $discount,
                'total' => $totalFee,
                'initial_payment' => $initialPayment,
            ]);
    
            // Calculate installment amounts
            $installmentAmount = $totalFee > 0 ? $totalFee / 4 : 0;
    
            // Insert payment details (divide total fee into four installments)
            $paymentsData = [
                'fee_id' => $fee->id,
                'prelims_payment' => $installmentAmount,
                'prelims_paid' => false,
                'midterms_payment' => $installmentAmount,
                'midterms_paid' => false,
                'pre_final_payment' => $installmentAmount,
                'pre_final_paid' => false,
                'final_payment' => $installmentAmount,
                'final_paid' => false,
                'amount_paid' => 0, // Set initial amount paid to 0
                'balance' => $totalFee, // Full balance initially
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


public function fees($id)
{
    $enrollment = Enrollment::with(['student', 'subjects', 'fees', 'fees.payments'])->findOrFail($id);

    // Initialize variables
    $totalFees = 0;
    $remainingBalance = 0;
    $installmentAmount = 0;
    $overallStatus = 'Paid';
    $balance = 0; // This will be the sum of all fees minus discounts and initial payment
    $remainingPayment = 0;
    $payment = null;

    if ($enrollment->fees && $enrollment->fees->payments) {
        $payment = $enrollment->fees->payments;

        // Fees calculation
        $tuitionFee = $enrollment->fees->tuition_fee ?? 0;
        $labFee = $enrollment->fees->lab_fee ?? 0;
        $miscFee = $enrollment->fees->miscellaneous_fee ?? 0;
        $otherFee = $enrollment->fees->other_fee ?? 0;
        $discount = $enrollment->fees->discount ?? 0;
        $initialPayment = $enrollment->fees->initial_payment ?? 0;

        // Step 1: Calculate the total fees (sum of all fees)
        $totalFees = $tuitionFee + $labFee + $miscFee + $otherFee;

        // Step 2: Calculate the balance after discount and initial payment
        $balance = $totalFees - $discount - $initialPayment;

        // Step 3: Calculate remaining balance after payments
        $remainingBalance = $balance;

        // Deduct payments made
        if ($payment->prelims_paid) {
            $remainingBalance -= $payment->prelims_payment;
        }
        if ($payment->midterms_paid) {
            $remainingBalance -= $payment->midterms_payment;
        }
        if ($payment->pre_final_paid) {
            $remainingBalance -= $payment->pre_final_payment;
        }
        if ($payment->final_paid) {
            $remainingBalance -= $payment->final_payment;
        }

        // Ensure no negative remaining balance
        $remainingBalance = max($remainingBalance, 0);

        // Step 4: Calculate installment amount (remaining balance divided by 4)
        $installmentAmount = $remainingBalance / 4;

        // Overall status calculation (whether all payments are made)
        $overallStatus = 'Paid';
        if (!$payment->prelims_paid || !$payment->midterms_paid || !$payment->pre_final_paid || !$payment->final_paid) {
            $overallStatus = 'Pending';
        }
    }

    // Return the view with the necessary data
    return view('enrollments.fees', compact('enrollment', 'totalFees', 'balance', 'installmentAmount', 'payment', 'remainingBalance', 'overallStatus'));
}

    



    // // Show the form to edit an enrollment
    // public function edit($id)
    // {
    //     $enrollment = Enrollment::findOrFail($id);
    //     $students = Student::all();
    //     $courses = Course::all();
    //     $semesters = Semester::all();
    //     $selectedSubjects = json_decode($enrollment->subjects, true) ?? [];

    //     $subjects = Subject::where('course_id', $enrollment->course_id)
    //                        ->where('year_level', $enrollment->year_level)
    //                        ->where('semester_id', $enrollment->semester_id)
    //                        ->get();

    //     return view('enrollments.edit', compact('enrollment', 'students', 'courses', 'semesters', 'subjects', 'selectedSubjects'));
    // }

    // // Update an enrollment
    // public function update(Request $request, $id)
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

    //     $enrollment = Enrollment::findOrFail($id);
    //     $enrollment->update([
    //         'student_id' => $validated['student_id'],
    //         'semester_id' => $validated['semester_id'],
    //         'course_id' => $validated['course_id'],
    //         'year_level' => $validated['year_level'],
    //         'subject_ids' => json_encode($validated['subjects']),
    //         'category'  => $validated['category'],
    //     ]);

    //     return redirect()->route('enrollments.index')->with('success', 'Enrollment updated successfully!');
    // }


    public function edit($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $students = Student::all();
        $courses = Course::all();
        $semesters = Semester::all();
        $subjects = Subject::where('course_id', $enrollment->course_id)
            ->where('semester_id', $enrollment->semester_id)
            ->where('year_level', $enrollment->year_level)
            ->get();

        $selectedSubjects = json_decode($enrollment->subject_ids, true);
        $fee = Fee::where('enrollment_id', $id)->first();

        return view('enrollments.edit', compact('enrollment', 'students', 'courses', 'semesters', 'subjects', 'selectedSubjects', 'fee'));
    }



    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'student_id' => 'sometimes|exists:students,id',
            'semester_id' => 'sometimes|exists:semesters,id',
            'course_id' => 'sometimes|exists:courses,id',
            'year_level' => 'sometimes|string',
            'subjects' => 'sometimes|array',
            'subjects.*' => 'exists:subjects,id',
            'category' => 'sometimes|string',
            'tuition_fee' => 'sometimes|numeric',
            'lab_fee' => 'sometimes|nullable|numeric',
            'miscellaneous_fee' => 'sometimes|nullable|numeric',
            'other_fee' => 'sometimes|nullable|numeric',
            'discount' => 'sometimes|nullable|numeric',
            'initial_payment' => 'sometimes|numeric',
        ]);

        try {
            DB::beginTransaction();

            // Find existing enrollment
            $enrollment = Enrollment::findOrFail($id);

            // Update only the provided fields
            $enrollment->update($request->only([
                'student_id',
                'semester_id',
                'course_id',
                'year_level',
                'category'
            ]));

            // Update student status if student_id is updated
            if ($request->has('student_id')) {
                Student::where('id', $validated['student_id'])->update(['status' => 'enrolled']);
            }

            // Update subjects if provided
            if ($request->has('subjects')) {
                StudentSubject::where('enrollment_id', $id)->delete();
                $studentSubjects = array_map(fn($subject_id) => [
                    'student_id' => $validated['student_id'] ?? $enrollment->student_id,
                    'subject_id' => $subject_id,
                    'enrollment_id' => $id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ], $validated['subjects']);

                StudentSubject::insert($studentSubjects);
            }

            // Update fees only if any fee-related field is sent
            $fee = Fee::where('enrollment_id', $id)->first();
            if ($fee) {
                $fee->update($request->only([
                    'tuition_fee',
                    'lab_fee',
                    'miscellaneous_fee',
                    'other_fee',
                    'discount',
                    'initial_payment'
                ]));

                // Recalculate balance and update payments
                $totalFee = $fee->tuition_fee + $fee->lab_fee + $fee->miscellaneous_fee + $fee->other_fee - $fee->discount;
                $payment = Payment::where('fee_id', $fee->id)->first();

                if ($payment) {
                    $balance = $totalFee - $payment->amount_paid;
                    $payment->update([
                        'prelims_payment' => $balance / 4,
                        'midterms_payment' => $balance / 4,
                        'pre_final_payment' => $balance / 4,
                        'final_payment' => $balance / 4,
                        'balance' => $balance,
                        'status' => $balance > 0 ? 'Pending' : 'Paid',
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('enrollments.index')->with('success', 'Enrollment updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update enrollment: ' . $e->getMessage());
        }
    }



}
