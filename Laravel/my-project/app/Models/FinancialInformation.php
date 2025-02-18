<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'financier',
        'company_name',
        'income',
        'address',
        'contact_number',
        'scholarship',
    ];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }
}
