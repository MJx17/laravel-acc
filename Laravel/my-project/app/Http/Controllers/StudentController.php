<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelPdf\Facades\Pdf;

class StudentController extends Controller
{
    // Show the enrollment form
    public function create()
    {
        // Get the currently authenticated user
        $user = Auth::user(); 
        $courses = Course::all(); 
        // Pass the user to the view
        return view('student.create', compact('user', 'courses'));
    }

    // Store the enrollment data
    public function store(Request $request)
    {
        // Validate the incoming data
        $validator = Validator::make($request->all(), [
            // Personal Information
            'surname' => 'required|string',
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'sex' => 'required|in:Male,Female,Other',
            'dob' => 'required|date',
            'age' => 'required|integer',
            'place_of_birth' => 'required|string',
            'home_address' => 'required|string',
            'mobile_number' => 'required|string',
            'email_address' => 'required|email',
         

            // Father's Information
            'fathers_name' => 'required|string',
            'fathers_educational_attainment' => 'required|string',
            'fathers_address' => 'required|string',
            'fathers_contact_number' => 'required|string',
            'fathers_occupation' => 'required|string',
            'fathers_employer' => 'required|string',
            'fathers_employer_address' => 'required|string',
            // Mother's Information
            'mothers_name' => 'required|string',
            'mothers_educational_attainment' => 'required|string',
            'mothers_address' => 'required|string',
            'mothers_contact_number' => 'required|string',
            'mothers_occupation' => 'required|string',
            'mothers_employer' => 'required|string',
            'mothers_employer_address' => 'required|string',
            // Guardian's Information (optional)
            'guardians_name' => 'nullable|string',
            'guardians_educational_attainment' => 'nullable|string',
            'guardians_address' => 'nullable|string',
            'guardians_contact_number' => 'nullable|string',
            'guardians_occupation' => 'nullable|string',
            'guardians_employer' => 'nullable|string',
            'guardians_employer_address' => 'nullable|string',
            // Living Situation
            'living_situation' => 'required|in:with_family,with_relatives,with_guardian,boarding_house',
            'living_address' => 'required|string',
            'living_contact_number' => 'required|string',
            // Year Level
    
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('student_images', 'public');
        }

        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Get the currently authenticated user
        $user = Auth::user();

        // Create a new student record
        Student::create([
            'user_id' => $user->id,
            'surname' => $request->surname,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'sex' => $request->sex,
            'dob' => $request->dob,
            'age' => $request->age,
            'place_of_birth' => $request->place_of_birth,
            'home_address' => $request->home_address,
            'mobile_number' => $request->mobile_number,
            'email_address' => $request->email_address,
            'image'=> $imagePath,

            

            'fathers_name' => $request->fathers_name,
            'fathers_educational_attainment' => $request->fathers_educational_attainment,
            'fathers_address' => $request->fathers_address,
            'fathers_contact_number' => $request->fathers_contact_number,
            'fathers_occupation' => $request->fathers_occupation,
            'fathers_employer' => $request->fathers_employer,
            'fathers_employer_address' => $request->fathers_employer_address,
            'mothers_name' => $request->mothers_name,
            'mothers_educational_attainment' => $request->mothers_educational_attainment,
            'mothers_address' => $request->mothers_address,
            'mothers_contact_number' => $request->mothers_contact_number,
            'mothers_occupation' => $request->mothers_occupation,
            'mothers_employer' => $request->mothers_employer,

            'mothers_employer_address' => $request->mothers_employer_address,
            'guardians_name' => $request->guardians_name,
            'guardians_educational_attainment' => $request->guardians_educational_attainment,
            'guardians_address' => $request->guardians_address,
            'guardians_contact_number' => $request->guardians_contact_number,
            'guardians_occupation' => $request->guardians_occupation,
            'guardians_employer' => $request->guardians_employer,
            'guardians_employer_address' => $request->guardians_employer_address,
            
            'living_situation' => $request->living_situation,
            'living_address' => $request->living_address,
            'living_contact_number' => $request->living_contact_number,
            
        ]);

        // Redirect to home page with success message
        return redirect()->route('home')->with('success', 'Enrollment successful!');
    }

    public function update(Request $request, $id)
{
    // Fetch the student data
    $student = Student::findOrFail($id);
    $courses = Course::findOrFail($id);
    // Validate the incoming data
    $validator = Validator::make($request->all(), [
        // Same validation rules as in store method
        'surname' => 'required|string',
        'first_name' => 'required|string',
        'middle_name' => 'nullable|string',
        'sex' => 'required|in:Male,Female,Other',
        'dob' => 'required|date',
        'age' => 'required|integer',
        'place_of_birth' => 'required|string',
        'home_address' => 'required|string',
        'mobile_number' => 'required|string',
        'email_address' => 'required|email',
   
        'status' => 'required|string',

        'fathers_name' => 'required|string',
        'fathers_educational_attainment' => 'required|string',
        'fathers_address' => 'required|string',
        'fathers_contact_number' => 'required|string',
        'fathers_occupation' => 'required|string',
        'fathers_employer' => 'required|string',
        'fathers_employer_address' => 'required|string',

        'mothers_name' => 'required|string',
        'mothers_educational_attainment' => 'required|string',
        'mothers_address' => 'required|string',
        'mothers_contact_number' => 'required|string',
        'mothers_occupation' => 'required|string',
        'mothers_employer' => 'required|string',
        'mothers_employer_address' => 'required|string',

        
        'guardians_name'  => 'nullable|string',
        'guardians_educational_attainment'  => 'nullable|string',
        'guardians_address' => 'nullable|string',
        'guardians_contact_number' => 'nullable|string',
        'guardians_occupation' => 'nullable|string',
        'guardians_employer' => 'nullable|string',
        'guardians_employer_address' => 'nullable|string',

        'living_situation' => 'required|in:with_family,with_relatives,with_guardian,boarding_house',
        'living_address' => 'required|string',
        'living_contact_number' => 'required|string',

        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // If validation fails, redirect back with errors
    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    // Handle image upload if provided
    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($student->image) {
            Storage::delete('public/' . $student->image);
        }
        // Store new image
        $image = $request->file('image');
        $imagePath = $image->store('student_images', 'public');
    } else {
        // Keep the old image if not uploading a new one
        $imagePath = $student->image;
    }

    // Update the student data
    $student->update([
        'surname' => $request->surname,
        'first_name' => $request->first_name,
        'middle_name' => $request->middle_name,
        'sex' => $request->sex,
        'dob' => $request->dob,
        'age' => $request->age,
        'place_of_birth' => $request->place_of_birth,
        'home_address' => $request->home_address,
        'mobile_number' => $request->mobile_number,
        'email_address' => $request->email_address,
    
        
        'fathers_name' => $request->fathers_name,
        'fathers_educational_attainment' => $request->fathers_educational_attainment,
        'fathers_address' => $request->fathers_address,
        'fathers_contact_number' => $request->fathers_contact_number,
        'fathers_occupation' => $request->fathers_occupation,
        'fathers_employer' => $request->fathers_employer,
        'fathers_employer_address' => $request->fathers_employer_address,

        'mothers_name' => $request->mothers_name,
        'mothers_educational_attainment' => $request->mothers_educational_attainment,
        'mothers_address' => $request->mothers_address,
        'mothers_contact_number' => $request->mothers_contact_number,
        'mothers_occupation' => $request->mothers_occupation,
        'mothers_employer' => $request->mothers_employer,
        'mothers_employer_address' => $request->mothers_employer_address,


        'guardians_name'  => 'nullable|string',
        'guardians_educational_attainment'  => 'nullable|string',
        'guardians_address' => 'nullable|string',
        'guardians_contact_number' => 'nullable|string',
        'guardians_occupation' => 'nullable|string',
        'guardians_employer' => 'nullable|string',
        'guardians_employer_address' => 'nullable|string',

        'living_situation' => $request->living_situation,
        'living_address' => $request->living_address,
        'living_contact_number' => $request->living_contact_number,
        
        'image' => $imagePath, // Update image if uploaded
    ]);

    // Redirect to a page with success message
    return redirect()->route('student.indexAdmin')->with('success', 'Student data updated successfully!');
}


        public function edit($id)
        {
            // Fetch the student data
            $student = Student::findOrFail($id);
            $courses = Course::findOrFail($id);
            // Return the edit view with the student data
            return view('student.edit', compact('student', 'courses'));
        }


        public function destroy($id)
        {
            // Fetch the student data
            $student = Student::findOrFail($id);
            $courses = Course::findOrFail($id);
            // Delete the student image from storage if it exists
            if ($student->image) {
                Storage::delete('public/' . $student->image);
            }

            // Delete the student record
            $student->delete();

            // Redirect to the admin index page with success message
            return redirect()->route('student.indexAdmin')->with('success', 'Student record deleted successfully!');
        }

        public function show($id)
        {
            // Retrieve student by ID
            $student = Student::findOrFail($id);
            $courses = Course::findOrFail($id);
            // Return a view to display the student's details
            return view('student.show', compact('student'));
        }



    // Admin view all students
    public function indexAdmin()
    {
        // Fetch all students (paginated)
        $students = Student::paginate(10);

        // Return the view with the students data
        return view('student.indexAdmin', compact('students'));
    }

    // Method for the student to view their own data
    public function indexStudent()
    {
        // Fetch the currently authenticated student's data
        $student = Auth::user()->student; // Assuming there is a relationship between User and Student models

        // Return the view with the student's data
        return view('student.indexStudent', compact('student'));
    }


//     public function downloadBlankForm()
//     {
//         // Render the blank enrollment form as a PDF
//         $pdf = Pdf::view('enrollment.pdf');  // No need to pass $user if we don't need it
    
//         // Download the PDF with the given filename
//         return $pdf->download('blank_enrollment_form.pdf');
//     }

// public function downloadFilledForm($id)
// {
//     // Ensure the user is authenticated
//     $student = Auth::user()->student;  // Ensure this is correct according to your relationships

//     // Fetch the enrollment data (ensure it exists)
//     $enrollment = Enrollment::findOrFail($id);  // Fetch specific enrollment data
    
//     // Render the filled enrollment form as a PDF
//     $pdf = Pdf::view('enrollment.index', [
//         'enrollment' => $enrollment,
//         'student' => $student  // Pass the student data to the view if necessary
//     ]);

//     // Download the filled form with the enrollment ID in the filename
//     return $pdf->download('filled_enrollment_form_' . $id . '.pdf');
// }
        
}
