<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeePayslipConfig extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'employee_id','basic','allowance1','hra','allowance2','da','gratuity',
        'travel_allowance','bonus','leave_allowance','other_allowance'
    ];

    public function employee(){ return $this->belongsTo(Employee::class); }
}
