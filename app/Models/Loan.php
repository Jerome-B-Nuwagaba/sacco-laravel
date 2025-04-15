<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{

    protected $fillable = [
        'user_id',
        'amount',
        'loan_type_id',
        'status',
    ];

    public function customer()
{
    return $this->belongsTo(User::class, 'customer_id', 'id');
}

    public function loanType()
{
    return $this->belongsTo(LoanType::class, 'loan_type_id', 'id');
}

public function paymentPlans()
{
    return $this->hasMany(PaymentPlan::class);
}
}
