<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeBankDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'account_holder_name',
        'bank_name',
        'branch',
        'account_no',
        'card_no',
        'ifsc_code',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}


