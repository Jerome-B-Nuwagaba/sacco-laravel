<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    public function loanType()
{
    return $this->belongsTo(LoanType::class);
}

public function paymentPlans()
{
    return $this->hasMany(PaymentPlan::class);
}
}
