<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentPlan extends Model
{
    protected $fillable = [
        'loan_id',
        'amount_per_installment',
        'number_of_installments',
        'completion_date',
        'installment_duration',
        'created_by',
        'accepted',
    ];
    

    protected $casts = [
        'completion_date' => 'date',
        'due_date' => 'date',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
