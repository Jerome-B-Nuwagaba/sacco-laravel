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
    return $this->belongsTo(User::class, 'user_id');
}

    public function loanType()
{
    return $this->belongsTo(LoanType::class);
}

public function paymentPlans()
{
    return $this->hasMany(PaymentPlan::class);
}
}
