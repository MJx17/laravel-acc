<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Enrollment;
use App\Models\Fee;
use App\Models\Payment;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SubjectPdfController extends Controller
{

        public function downloadSubjectsPDF($studentId)
        {
            // Fetch enrollment data for the specific student
            $enrollment = Enrollment::with('subjects.professor', 'student', 'semester', 'course')
                                    ->where('student_id', $studentId)
                                    ->first();
            
            if (!$enrollment) {
                return response()->json(['error' => 'Enrollment not found for this student'], 404);
            }
            
            // Prepare the student info
            $studentImage = null;

            // Check if student has an image and encode it as base64
            if ($enrollment->student->image) {
                $imagePath = storage_path('app/public/' . $enrollment->student->image);
                if (File::exists($imagePath)) {
                    // Convert image to base64
                    $imageData = file_get_contents($imagePath);
                    $studentImage = 'data:image/' . pathinfo($imagePath, PATHINFO_EXTENSION) . ';base64,' . base64_encode($imageData);
                }
            }
            
            // If no image, use null to fallback to the placeholder in the view
            if (!$studentImage) {
                $studentImage = null;
            }
            
    
            // Base64 encode the logo (same logic)
            $logoPath = public_path('images/logo.jpg');
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/jpeg;base64,' . base64_encode($logoData);
            
            // Collect the necessary student info and subjects data
            $studentInfo = [
                'surname'=> $enrollment->student->surname,
                'first_name' => $enrollment->student->first_name, 
                'middle_name' => $enrollment->student->middle_name,
                'name' => $enrollment->student->surname . ', ' . $enrollment->student->first_name . ' ' . $enrollment->student->middle_name,
                'student_id' => $enrollment->student->id ?? 'N/A',
                'semester' => $enrollment->semester->semester_text ?? 'N/A',
                'year_level' => $enrollment->formatted_year_level ?? 'N/A',
                'category' => $enrollment->category ?? 'N/A',
                'academic_year' => $enrollment->semester->academic_year ?? 'N/A',
                'course' => $enrollment->course->course_name ?? 'N/A',
                'major' => $enrollment->course->major ?? 'N/A',
                'image' => $studentImage, // Base64 student image
                'logo' => $logoBase64,     // Base64 logo image
            ];
        
            // Generate the PDF from the view, passing both subjects and student information
            $pdf = PDF::loadView('pdf.subjects', [
                'subjects' => $enrollment->subjects,
                'studentInfo' => $studentInfo,
                'enrollment' => $enrollment
            ]);
        
            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
                'isCssFloatEnabled' => true
            ]);
        
            // Return the response with the PDF output
            return response($pdf->output(), 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="enrolled_subjects_' . $studentId . '.pdf"');
        }


public function fees($id)
{
    // Fetch the enrollment with all related models: student, subjects, professor, semester, course, and fees/payments
    $enrollment = Enrollment::with([
        'student', 
        'subjects.professor', 
        'semester', 
        'course', 
        'fees.payments' // Load all fees along with their payments
    ])->findOrFail($id);

    if (!$enrollment) {
        return response()->json(['error' => 'Enrollment not found for this student'], 404);
    }

    // Fetch the first associated Fee record for the enrollment
    $fees = $enrollment->fees; // We can use the relationship directly here
    $payment = $fees ? $fees->payments()->latest()->first() : null;

    // Student info
    $studentImage = null;
    if ($enrollment->student->image) {
        $imagePath = storage_path('app/public/' . $enrollment->student->image);
        if (File::exists($imagePath)) {
            $imageData = file_get_contents($imagePath);
            $studentImage = 'data:image/' . pathinfo($imagePath, PATHINFO_EXTENSION) . ';base64,' . base64_encode($imageData);
        }
    }

    $logoPath = public_path('images/logo.jpg');
    $logoData = file_get_contents($logoPath);
    $logoBase64 = 'data:image/jpeg;base64,' . base64_encode($logoData);

    // Prepare student info array
    $studentInfo = [
        'surname' => $enrollment->student->surname,
        'first_name' => $enrollment->student->first_name, 
        'middle_name' => $enrollment->student->middle_name,
        'name' => $enrollment->student->surname . ', ' . $enrollment->student->first_name . ' ' . $enrollment->student->middle_name,
        'student_id' => $enrollment->student->id ?? 'N/A',
        'semester' => $enrollment->semester->semester_text ?? 'N/A',
        'year_level' => $enrollment->formatted_year_level ?? 'N/A',
        'category' => $enrollment->category ?? 'N/A',
        'academic_year' => $enrollment->semester->academic_year ?? 'N/A',
        'course' => $enrollment->course->course_name ?? 'N/A',
        'major' => $enrollment->course->major ?? 'N/A',
        'image' => $studentImage,
        'logo' => $logoBase64,
    ];

    // Fee calculations
    $totalFee = 0;
    $overallStatus = 'No Fees Found';
    $remainingBalance = 0;
    $amountPaid = 0;

    
    
    if ($fees) {
        $tuitionFee = $fees->tuition_fee ?? 0;
        $labFee = $fees->lab_fee ?? 0;
        $miscellaneousFee = $fees->miscellaneous_fee ?? 0;
        $otherFee = $fees->other_fee ?? 0;
        $discount = $fees->discount ?? 0;
        $initialPayment = $fees->initial_payment ?? 0;
    
        // Calculate total fee after applying discount and initial payment
        $totalFee = ($tuitionFee + $labFee + $miscellaneousFee + $otherFee - $discount - $initialPayment);
    
        // Initialize remaining balance with total fee
        $remainingBalance = $totalFee;
    
        // Calculate the amount paid from initial payment and installment payments
        $amountPaid = $initialPayment;
    
        if ($payment) {
            // Subtract payments made (prelims, midterms, etc.) from remaining balance
            $remainingBalance -= $payment->prelims_paid ? $payment->prelims_payment : 0;
            $amountPaid += $payment->prelims_paid ? $payment->prelims_payment : 0;
    
            $remainingBalance -= $payment->midterms_paid ? $payment->midterms_payment : 0;
            $amountPaid += $payment->midterms_paid ? $payment->midterms_payment : 0;
    
            $remainingBalance -= $payment->pre_final_paid ? $payment->pre_final_payment : 0;
            $amountPaid += $payment->pre_final_paid ? $payment->pre_final_payment : 0;
    
            $remainingBalance -= $payment->final_paid ? $payment->final_payment : 0;
            $amountPaid += $payment->final_paid ? $payment->final_payment : 0;
    
            // Determine overall status based on remaining balance
            $overallStatus = ($remainingBalance > 0) ? 'Pending' : 'Paid';
        }
    } else {
        // Default values if no fee details are found
        $totalFee = 0;
        $remainingBalance = 0;
        $amountPaid = 0;
        $overallStatus = 'No Fees Found';
    }
    
    // Return the results (can be passed to a view or returned as an array, as needed)
  
    // Generate the PDF
    $pdf = PDF::loadView('pdf.fees', [
        'subjects' => $enrollment->subjects,
        'studentInfo' => $studentInfo,
        'enrollment' => $enrollment,
        'fees' => $fees,
        'payment' => $payment, 
        'remainingBalance' => $remainingBalance,
        'overallStatus' => $overallStatus,
        'totalFees' => $totalFee,
    ]);

    $pdf->setOptions([
        'isHtml5ParserEnabled' => true,
        'isPhpEnabled' => true,
        'isCssFloatEnabled' => true,
        'font' => 'DejaVu Sans'
    ]);

    return response($pdf->output(), 200)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="enrolled_subjects_' . $id . '.pdf"');
}

    
}
 