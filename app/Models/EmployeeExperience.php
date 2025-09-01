<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeExperience extends Model
{
    use SoftDeletes;

    protected $fillable = ['employee_id','company_name','designation','experience'];

    public function employee(){ return $this->belongsTo(Employee::class); }
}
