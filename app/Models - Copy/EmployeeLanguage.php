<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeLanguage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'language',
        'can_read',
        'can_write',
        'can_speak',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}


