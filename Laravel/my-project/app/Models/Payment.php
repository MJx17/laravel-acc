<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'enrollment_id',
        'initial_payment',
        'prelims_payment',
        'midterms_payment',
        'pre_final_payment',
        'final_payment'
    ];

    // Relationship: A payment belongs to an enrollment
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    // Computed Total Paid Amount
    public function getTotalPaidAttribute()
    {
        return $this->initial_payment + $this->prelims_payment + $this->midterms_payment + $this->pre_final_payment + $this->final_payment;
    }

    // Computed Remaining Balance
    public function getRemainingBalanceAttribute()
    {
        $fee = $this->enrollment->fee; // Get related fee
        return $fee->total_fee - $this->total_paid;
    }
    public function fee()
    {
        return $this->belongsTo(Fee::class);
    }
}
