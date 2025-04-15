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
        'paid_at',
    ];

    protected $dates = [
        'paid_at',
    ];

    // Relationships
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
