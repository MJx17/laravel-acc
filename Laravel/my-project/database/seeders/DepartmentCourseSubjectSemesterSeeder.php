<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Enrollment;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Professor;
use App\Models\CourseSubject;
use App\Models\StudentSubject;
use App\Models\ProfessorSubject;
use Carbon\Carbon;

class DepartmentCourseSubjectSemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Step 1: Create Departments
        $departments = [
            'Business Administration',
            'Tourism Management',
            'Secondary Education',
            'Criminology',
            'Computer Science',
            'Nursing'
        ];

        foreach ($departments as $departmentName) {
            Department::create(['name' => $departmentName]);
        }

        // Step 2: Create Courses
        $course1 = Course::create([
            'course_code' => 'BSN',
            'course_name' => 'Bachelor of Science in Nursing',
            'description' => 'A program that prepares students for careers in nursing.',
            'units' => 3,
            'department_id' => 6,  // Department ID for Nursing
        ]);

        $course2 = Course::create([
            'course_code' => 'BSCrim',
            'course_name' => 'Bachelor of Science in Criminology',
            'description' => 'A program focused on criminal law enforcement and justice.',
            'units' => 3,
            'department_id' => 4,  // Department ID for Criminology
        ]);

        $course3 = Course::create([
            'course_code' => 'BSCS',
            'course_name' => 'Bachelor of Science in Computer Science',
            'description' => 'A program for students pursuing careers in software development and computer systems.',
            'units' => 3,
            'department_id' => 5,  // Department ID for Computer Science
        ]);

        $course4 = Course::create([
            'course_code' => 'BSBA',
            'course_name' => 'Bachelor of Science in Business Administration',
            'description' => 'A program focused on business management and administration.',
            'units' => 3,
            'department_id' => 1,  // Department ID for Business Administration
        ]);

        // Majors for Business Administration (BSBA)
        $course5 = Course::create([
            'course_code' => 'BSBA-OPM',
            'course_name' => 'Bachelor of Science in Business Administration - Operation Management',
            'description' => 'A major focused on managing business operations.',
            'units' => 3,
            'major' => 'Operation Management',
            'department_id' => 1,  // Department ID for Business Administration
        ]);

        // Step 3: Create Semesters
        $semester1 = Semester::create([
            'academic_year' => '2022-2023',
            'semester' => '1st',
            'start_date' => Carbon::parse('2022-08-01'),
            'end_date' => Carbon::parse('2022-12-15'),
        ]);

        $semester2 = Semester::create([
            'academic_year' => '2022-2023',
            'semester' => '2nd',
            'start_date' => Carbon::parse('2023-01-10'),
            'end_date' => Carbon::parse('2023-05-15'),
        ]);

                // Fetch professors
        $professor1 = Professor::find(1);
        $professor2 = Professor::find(2);

        // Step 4: Create Subjects
        
        $ge1 = Subject::create([
            'name' => 'Understanding the Self',
            'code' => 'GE 1',
            'semester_id' => $semester1 ->id,
            'prerequisite_id' => null,
            'fee' => 500, // Example fee
            'units' => 3,
            'year_level' => 1,
            'block' => 'A', // Example block
            'professor_id' => $professor1->id,
            'course_id' => $course1->id,
        ]);
        
        $ge2 = Subject::create([
            'name' => 'Reading in Philippine History',
            'code' => 'GE 2',
            'semester_id' => $semester1->id,
            'prerequisite_id' => null,
            'fee' => 400, // Example fee
            'units' => 3,
            'year_level' => 1,
            'block' => 'A', // Example block
            'professor_id' => $professor1->id,
            'course_id' => $course1->id,
        ]);
    
        $ge3 = Subject::create([
            'name' => 'The Contemporary World',
            'code' => 'GE 3',
            'semester_id' => $semester1->id,
            'prerequisite_id' => null,
            'fee' => 450, // Example fee
            'units' => 3,
            'year_level' => 1,
            'block' => 'A', // Example block
            'professor_id' => $professor1->id,
            'course_id' => $course1->id,
        ]);
    
        $ge4 = Subject::create([
            'name' => 'Mathematics in the Modern World',
            'code' => 'GE 4',
            'semester_id' => $semester1->id,
            'prerequisite_id' => null,
            'fee' => 600, // Example fee
            'units' => 3,
            'year_level' => 1,
            'block' => 'A', // Example block
            'professor_id' => $professor1->id,
            'course_id' => $course1->id,
        ]);
    
        $ba1 = Subject::create([
            'name' => 'Principles of Management and Organization',
            'code' => 'BA 1',
            'semester_id' => $semester1->id,
            'prerequisite_id' => null,
            'fee' => 800, // Example fee
            'units' => 3,
            'year_level' => 1,
            'block' => 'A', // Example block
            'professor_id' => $professor1->id,
            'course_id' => $course1->id,
        ]);
    
        $pe1 = Subject::create([
            'name' => 'Fundamentals of Motor Skills',
            'code' => 'PE 1',
            'semester_id' => $semester1->id,
            'prerequisite_id' => null,
            'fee' => 200, // Example fee
            'units' => 1,
            'year_level' => 1,
            'block' => 'A', // Example block
            'professor_id' => $professor1->id,
            'course_id' => $course1->id,
        ]);
    
        $nstp1 = Subject::create([
            'name' => 'National Service Training Program',
            'code' => 'NSTP 1',
            'semester_id' => $semester1->id,
            'prerequisite_id' => null,
            'fee' => 0, // Typically free, unless there is a fee
            'units' => 3,
            'year_level' => 1,
            'block' => 'A', // Example block
            'professor_id' => $professor1->id,
            'course_id' => $course1->id,
        ]);
    
        $perDev1 = Subject::create([
            'name' => 'ACC Standard',
            'code' => 'Per Dev 1',
            'semester_id' => $semester1->id,
            'prerequisite_id' => null,
            'fee' => 100, // Example fee
            'units' => 1,
            'year_level' => 1,
            'block' => 'A', // Example block
            'professor_id' => $professor1->id,
            'course_id' => $course1->id,
        ]);
    
    
        $ge5 = Subject::create([
            'name' => 'Purposive Communication',
            'code' => 'GE 5',
            'semester_id' => $semester2->id,
            'prerequisite_id' => null, // Prerequisite GE 4
            'fee' => 500, // Example fee
            'units' => 3,
            'year_level' => 1,
            'block' => 'A', // Example block
            'professor_id' => $professor1->id,
            'course_id' => $course1->id,
        ]);
    
        $ge6 = Subject::create([
            'name' => 'Art Appreciation',
            'code' => 'GE 6',
            'semester_id' => $semester2->id,
            'prerequisite_id' => null, // Prerequisite GE 5
            'fee' => 450, // Example fee
            'units' => 3,
            'year_level' => 1,
            'block' => 'A', // Example block
            'professor_id' => $professor1->id,
            'course_id' => $course1->id,
        ]);
    
        $ge7 = Subject::create([
            'name' => 'Science, Technology, and Society',
            'code' => 'GE 7',
            'semester_id' => $semester2->id,
            'prerequisite_id' => null, // Prerequisite GE 6
            'fee' => 600, // Example fee
            'units' => 3,
            'year_level' => 1,
            'block' => 'A', // Example block
            'professor_id' => $professor1->id,
            'course_id' => $course1->id,
        ]);
    
        $ge8 = Subject::create([
            'name' => 'Ethics',
            'code' => 'GE 8',
            'semester_id' => $semester2->id,
            'prerequisite_id' => null, // Prerequisite GE 7
            'fee' => 400, // Example fee
            'units' => 3,
            'year_level' => 1,
            'block' => 'A', // Example block
            'professor_id' => $professor1->id,
            'course_id' => $course1->id,
        ]);
    
        $eco1 = Subject::create([
            'name' => 'Introduction to Economics w/ TAR',
            'code' => 'Eco 1',
            'semester_id' => $semester2->id,
            'prerequisite_id' => null, // No prerequisite
            'fee' => 700, // Example fee
            'units' => 3,
            'year_level' => 1,
            'block' => 'A', // Example block
            'professor_id' => $professor1->id,
            'course_id' => $course1->id,
        ]);
    
        $pe2 = Subject::create([
            'name' => 'Fundamentals of Rhythm & Dances',
            'code' => 'PE 2',
            'semester_id' => $semester2->id,
            'prerequisite_id' => $pe1->id, // Prerequisite PE 1
            'fee' => 250, // Example fee
            'units' => 2,
            'year_level' => 1,
            'block' => 'A', // Example block
            'professor_id' => $professor1->id,
            'course_id' => $course1->id,
        ]);
    
        $nstp2 = Subject::create([
            'name' => 'National Service Training Program',
            'code' => 'NSTP 2',
            'semester_id' => $semester2->id,
            'prerequisite_id' => $nstp1->id, // Prerequisite NSTP 1
            'fee' => 0, // Typically free, unless there is a fee
            'units' => 3,
            'year_level' => 1,
            'block' => 'A', // Example block
            'professor_id' => $professor1->id,
            'course_id' => $course1->id,
        ]);
    
        $perDev2 = Subject::create([
            'name' => 'Acc Quality',
            'code' => 'Per Dev 2',
            'semester_id' => $semester2->id,
            'prerequisite_id' => $perDev1->id, // Prerequisite Per Dev 1
            'fee' => 100, // Example fee
            'units' => 3,
            'year_level' => 1,
            'block' => 'A', // Example block
            'professor_id' => $professor1->id,
            'course_id' => $course1->id,
        ]);

            // Create the necessary subjects (same as before)
        $subjects = [
            'Per Dev 2' => Subject::where('name', 'Per Dev 2')->first(),
            'NSTP 2' => Subject::where('name', 'NSTP 2')->first(),
            'Eco 1' => Subject::where('name', 'Eco 1')->first(),
        ];


        $student1 = Student::find(1);  // Assuming student ID 1 exists
        $student2 = Student::find(2);  // Assuming student ID 2 exists

        // Ensure semester and course are defined
        $semester = Semester::find(1); // or another method to get the semester
        $course = Course::find(1); // or another method to get the course

        // Check if semester and course exist
        if (!$semester || !$course) {
            $this->command->error("Semester or Course not found.");
            return;
        }

        // Assign Subjects to Students based on Year Level and Enrollment Data
        if ($student1) {
            $this->assignSubjectsToStudent($student1->id, '1st_year', $semester->id, $course->id, [$pe2, $nstp2, $perDev2]); // Student 1 - 1st Year
        }

        if ($student2) {
            $this->assignSubjectsToStudent($student2->id, '2nd_year', $semester->id, $course->id, []); // Student 2 - 2nd Year (No subjects)
        }

        $this->command->info('Students enrolled in correct subjects.');
    }

    // Define the method outside of the `run` method.
    private function assignSubjectsToStudent($studentId, $yearLevel, $semesterId, $courseId, $subjects)
    {
        // Check if the student is already enrolled
        $enrollment = Enrollment::where([
            'student_id' => $studentId,
            'year_level' => $yearLevel,
            'semester_id' => $semesterId,
            'course_id' => $courseId,
        ])->first();

        // If enrollment does not exist, create it
        if (!$enrollment) {
            $enrollment = Enrollment::create([
                'student_id' => $studentId,
                'year_level' => $yearLevel,
                'semester_id' => $semesterId,
                'course_id' => $courseId,
            ]);
        }

        // Now loop through subjects and assign them to the student if subjects are provided
        foreach ($subjects as $subject) {
            if ($subject) {
                // Create the student-subject association
                StudentSubject::create([
                    'student_id' => $studentId,
                    'subject_id' => $subject->id,
                    'enrollment_id' => $enrollment->id,
                    'status' => 'enrolled',
                    'grade' => null,
                ]);
            }
        }

                    
                    
            
        
        
    }
}
