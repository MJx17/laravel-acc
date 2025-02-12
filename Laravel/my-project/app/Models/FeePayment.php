<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeePayment extends Model
{
    use HasFactory;

    // Define the table name (optional if it's the plural form of the model name)
    protected $table = 'fee_payments';

    // Mass assignable fields
    protected $fillable = [
        'enrollment_id',
        'tuition_fee',
        'lab_fee',
        'miscellaneous_fee',
        'other_fee',
        'initial_payment',
        'prelims_payment',
        'midterms_payment',
        'pre_final_payment',
        'final_payment',
    ];

    // You can also define relationships (if necessary)
    
    // Example: A FeePayment belongs to an Enrollment
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }
}
