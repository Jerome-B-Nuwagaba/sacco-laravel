<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentPlan extends Model
{
    protected $fillable = [
        'loan_id', 'amount_per_installment', 'duration', 'number_of_installments', 'completion_date', 'accepted'
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
