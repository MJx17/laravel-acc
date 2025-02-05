<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Subject extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',          // Subject name
        'code',          // Unique subject code
        'block',         // Block or class group
        'semester_id',   // References the Semester table
        'prerequisite_id', // References another subject as a prerequisite
        'fee',           // Subject fee
        'units',         // Subject units
        'course_id',
         'professor_id',
        'year_level',    // Year level the subject belongs to
    ];

    /**
     * Relationships
     */

    // Relation to Semester
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    // Relation to prerequisite subject
    public function prerequisite()
    {
        return $this->belongsTo(Subject::class, 'prerequisite_id');
    }

    // Relation to subjects that depend on this as a prerequisite
    public function dependentSubjects()
    {
        return $this->hasMany(Subject::class, 'prerequisite_id');
    }

    // Many-to-Many: Relation to Students through enrollment
    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_subject')
            ->withPivot('grade', 'status')  // Access grade and status in the pivot table
            ->withTimestamps();
    }

    // Many-to-Many: Relation to Courses

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Many-to-Many: Relation to Professors
  
    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    /**
     * Method to get the subject's grade and status in the pivot for students
     */
    public function getStudentPivotData($studentId)
    {
        return $this->students()->where('student_id', $studentId)->first()->pivot;
    }

    /**
     * Method to attach professors to a subject with additional pivot data (e.g., semester)
     */
    public function assignProfessorToSubject($professorId, $pivotData = [])
    {
        return $this->professors()->attach($professorId, $pivotData);
    }

    /**
     * Method to attach courses to a subject with additional pivot data (e.g., semester)
     */
    public function assignCourseToSubject($courseId, $pivotData = [])
    {
        return $this->courses()->attach($courseId, $pivotData);
    }
    
    public function enrollments()
    {
        return $this->belongsToMany(Enrollment::class);
    }

}
