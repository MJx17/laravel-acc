<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Enrollment;
use Illuminate\Support\Facades\File;

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
    
        // Collect student information
        $studentInfo = [
            'name' => $enrollment->student->surname . ', ' . $enrollment->student->first_name . ' ' . $enrollment->student->middle_name,
            'student_id' => $enrollment->student->id ?? 'N/A',
            'semester' => $enrollment->semester->semester_text ?? 'N/A',
            'year_level' => $enrollment->formatted_year_level ?? 'N/A',
            'category' => $enrollment->category ?? 'N/A',
            'academic_year' => $enrollment->semester->academic_year ?? 'N/A',
            'course' => $enrollment->course->course_name ?? 'N/A',
            'major' => $enrollment->course->major ?? 'N/A',
        ];
    
        // Convert logo image to Base64 (if required)
        $logoPath = public_path('images/logo.jpg');
        $logo = File::exists($logoPath) ? 'data:image/jpeg;base64,' . base64_encode(File::get($logoPath)) : null;
    
        // Handle Student Image with Direct URL (using asset())
        $studentImage = null;
    
        if ($enrollment->student->image) {
            $imageUrl = asset('storage/' . $enrollment->student->image);  // Direct URL to the student image
            
            // Check if image exists at the given URL (you can perform a check using file_get_contents or other means)
            try {
                $imageData = file_get_contents($imageUrl); // Ensure the image is accessible
                if ($imageData) {
                    $studentImage = $imageUrl;  // Assign the URL directly to use in the PDF
                }
            } catch (\Exception $e) {
                // Handle missing or inaccessible images
                $studentImage = null;
            }
        }
    
        // Use Placeholder Image if Student Image is Missing
        if (!$studentImage) {
            $studentImage = asset('images/placeholder.jpg');  // Placeholder image URL
        }
    
        // Generate the PDF from the view, passing both image URLs (logo and student)
        $pdf = PDF::loadView('pdf.subjects', [
            'subjects' => $enrollment->subjects,
            'studentInfo' => $studentInfo,
            'logo' => $logo,
            'studentImage' => $studentImage,
            'enrollment' => $enrollment
        ]);
    
        // Output the PDF to the browser
        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="enrolled_subjects_' . $studentId . '.pdf"');
    }
    

}
