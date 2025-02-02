<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Enrollment extends Model
{
    protected $fillable = [
        'student_id',
        'semester_id',
        'course_id',
        'year_level',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'student_subject')->withTimestamps();
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);  // Added the course relationship
    }
}
