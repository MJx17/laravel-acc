<?php
// app/Http/Kernel.php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Spatie\Permission\Middlewares\RoleMiddleware; // Correct import

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        // Your other global middleware
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'role' => RoleMiddleware::class,  // Register 'role' middleware here
        // Other middlewares you want to add can go here
    ];
}



// public function edit($id)
// {
//     $enrollment = Enrollment::findOrFail($id);
//     $students = Student::all();
//     $courses = Course::all();
//     $semesters = Semester::all();
//     $selectedSubjects = json_decode($enrollment->subject_ids, true) ?? []; // Retrieve subjects from 'subject_ids' instead of 'subjects'
    
//     $subjects = Subject::where('course_id', $enrollment->course_id)
//                     ->where('year_level', $enrollment->year_level)
//                     ->where('semester_id', $enrollment->semester_id)
//                     ->get();

//     // Load fee details
//     $fee = Fee::where('enrollment_id', $enrollment->id)->first();
    
//     // Get existing payment data
//     $payment = Payment::where('enrollment_id', $enrollment->id)->first();

//     return view('enrollments.edit', compact('enrollment', 'students', 'courses', 'semesters', 'subjects', 'selectedSubjects', 'fee', 'payment'));
// }



//     // Show the form to edit an enrollment
//  // Show the form to edit an enrollment
//  public function update(Request $request, $id)
//  {
//      $validated = $request->validate([
//          'student_id' => 'required|exists:students,id',
//          'semester_id' => 'required|exists:semesters,id',
//          'course_id' => 'required|exists:courses,id',
//          'year_level' => 'required|string',
//          'subjects' => 'required|array',
//          'subjects.*' => 'exists:subjects,id',
//          'category'  => 'required|string',
//          'tuition_fee' => 'required|numeric',
//          'lab_fee' => 'nullable|numeric',
//          'miscellaneous_fee' => 'nullable|numeric',
//          'other_fee' => 'nullable|numeric',
//          'discount' => 'nullable|numeric',
//      ]);
 
//      $enrollment = Enrollment::findOrFail($id);
 
//      DB::beginTransaction(); // Start transaction
 
//      try {
//          // Update the enrollment
//          $enrollment->update([
//              'student_id' => $validated['student_id'],
//              'semester_id' => $validated['semester_id'],
//              'course_id' => $validated['course_id'],
//              'year_level' => $validated['year_level'],
//              'subject_ids' => json_encode($validated['subjects']),
//              'category' => $validated['category'],
//          ]);
 
//          // Update student status to 'enrolled' if necessary
//          if ($enrollment->student_id != $validated['student_id']) {
//              Student::where('id', $validated['student_id'])->update(['status' => 'enrolled']);
//          }
 
//          // Update the subjects in student_subjects table
//          StudentSubject::where('enrollment_id', $enrollment->id)->delete(); // Remove old subjects
//          $studentSubjects = [];
//          foreach ($validated['subjects'] as $subject_id) {
//              $studentSubjects[] = [
//                  'student_id' => $validated['student_id'],
//                  'subject_id' => $subject_id,
//                  'enrollment_id' => $enrollment->id,
//                  'created_at' => now(),
//                  'updated_at' => now(),
//              ];
//          }
//          StudentSubject::insert($studentSubjects); // Insert new subjects
 
//          // Calculate total fee and initial payment
//          $tuitionFee = $validated['tuition_fee'];
//          $labFee = $validated['lab_fee'] ?? 0;
//          $miscellaneousFee = $validated['miscellaneous_fee'] ?? 0;
//          $otherFee = $validated['other_fee'] ?? 0;
//          $discount = $validated['discount'] ?? 0;
 
//          $totalFee = $tuitionFee + $labFee + $miscellaneousFee + $otherFee;
//          $netFee = $totalFee - $discount;
 
//          // Check if Fee exists, else create it
//          $fee = Fee::where('enrollment_id', $enrollment->id)->first();
//          if (!$fee) {
//              $fee = new Fee();
//              $fee->enrollment_id = $enrollment->id;
//          }
//          $fee->update([
//              'tuition_fee' => $tuitionFee,
//              'lab_fee' => $labFee,
//              'miscellaneous_fee' => $miscellaneousFee,
//              'other_fee' => $otherFee,
//              'discount' => $discount,
//              'total' => $totalFee,
//              'initial_payment' => $netFee * 0.25, // Update initial payment
//          ]);
 
//          // Check if Payment exists, else create it
//          $payment = Payment::where('enrollment_id', $enrollment->id)->first();
//          if (!$payment) {
//              $payment = new Payment();
//              $payment->enrollment_id = $enrollment->id;
//          }
//          $paymentsData = [
//              'prelims_payment' => $netFee / 4,
//              'prelims_paid' => false,
//              'midterms_payment' => $netFee / 4,
//              'midterms_paid' => false,
//              'pre_final_payment' => $netFee / 4,
//              'pre_final_paid' => false,
//              'final_payment' => $netFee / 4,
//              'final_paid' => false,
//              'amount_paid' => $fee->initial_payment,
//              'balance' => $netFee - $fee->initial_payment,
//              'status' => 'Pending',
//          ];
//          $payment->update($paymentsData);
 
//          DB::commit(); // Commit transaction
 
//          return redirect()->route('enrollments.index')->with('success', 'Enrollment updated successfully!');
//      } catch (\Exception $e) {
//          DB::rollBack(); // Rollback in case of an error
//          return back()->with('error', 'Failed to update enrollment: ' . $e->getMessage());
//      }
//  }
 