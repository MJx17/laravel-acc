<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'semesters';

    // The attributes that are mass assignable.
    protected $fillable = [
        'academic_year',
        'semester',
        'start_date',
        'end_date',
    ];

    // If you're using timestamps (created_at and updated_at), no need to define this unless you want custom behavior
    public $timestamps = true;

    
    public function getFullSemesterAttribute()
    {
        return $this->semester . ' Semester - ' . $this->academic_year;
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

}
