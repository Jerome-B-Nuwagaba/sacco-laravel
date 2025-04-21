<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'amount',
        'payment_date',
    ];

    protected $dates = [
        'payment_date',
    ];

    // Relationships
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
    public function paymentPlan()
    {
        return $this->belongsTo(PaymentPlan::class);
    }

}
