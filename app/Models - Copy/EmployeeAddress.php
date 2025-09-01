<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeAddress extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id', 'type', 'address_line1', 'address_line2', 'city', 'state', 'pincode'
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
