<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'surname',
        'first_name',
        'middle_name',
        'sex',
        'dob',
        'age',
        'place_of_birth',
        'home_address',
        'mobile_number',
        'email_address',

        'fathers_name',
        'fathers_educational_attainment',
        'fathers_address',
        'fathers_contact_number',
        'fathers_occupation',
        'fathers_employer',
        'fathers_employer_address',

        'mothers_name',
        'mothers_educational_attainment',
        'mothers_address',
        'mothers_contact_number',
        'mothers_occupation',
        'mothers_employer',
        'mothers_employer_address',

        'guardians_name',
        'guardians_educational_attainment',
        'guardians_address',
        'guardians_contact_number',
        'guardians_occupation',
        'guardians_employer',
        'guardians_employer_address',
        
        'living_situation',
        'living_address',
        'living_contact_number',
        'image',
        'status'
    ];

    /**
     * Relationship with User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with Grades.
     */
    public function grades()
    {
        return $this->hasMany(Grade::class, 'student_id');
    }

    /**
     * Relationship with Subjects (enrollment data moved to subject_student table).
     */
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'student_subject')
                    ->withPivot('status', 'remarks')  // Including enrollment status and remarks
                    ->withTimestamps();
    }

    public function professors()
    {
        return $this->belongsToMany(Professor::class, 'professor_subject');
    }


    /**
     * Relationship with Course.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Dynamically get the year level based on enrolled subjects and other criteria.
     */
    public function getYearLevelAttribute()
    {
        // Logic to determine year level based on enrolled subjects or course progress
        // Example: Check how many subjects have been completed and derive year level.
        // You can use the count of subjects or subject units to derive this value dynamically.
        $enrolledSubjectsCount = $this->subjects()->count();
        
        if ($enrolledSubjectsCount <= 5) {
            return '1st_year';
        } elseif ($enrolledSubjectsCount <= 10) {
            return '2nd_year';
        } elseif ($enrolledSubjectsCount <= 15) {
            return '3rd_year';
        } else {
            return '4th_year';
        }
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->surname;
    }

        public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

}
