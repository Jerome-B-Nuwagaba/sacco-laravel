<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'amount',
        'loan_type_id',
        'status',
        'loan_officer_id'
    ];

    public function customer()
{
    return $this->belongsTo(User::class, 'customer_id', 'id');
}
public function loanOfficer()
 {
     return $this->belongsTo(User::class, 'loan_officer_id');
 }
    public function loanType()
{
    return $this->belongsTo(LoanType::class, 'loan_type_id', 'id');
}

public function paymentPlan()
{
    return $this->hasOne(PaymentPlan::class);
}


public function payments()
{
    return $this->hasMany(Payment::class);
}
public function latestPayment(): HasOne
    {
        return $this->hasOne(PaymentPlan::class)->latestOfMany();
    }
}
