<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeEnclosure extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'document_type',
        'is_original',
        'is_xerox',
        'proof_no',
        'file_path',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}


