<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeOfficialDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'role',
        'date_of_join',
        'employee_type',
        'salary',
        'pf_number',
        'esi_number',
        'pf_calculation',
        'esi_calculation',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}


