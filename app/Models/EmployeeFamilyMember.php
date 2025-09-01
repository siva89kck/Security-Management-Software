<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeFamilyMember extends Model
{
    use SoftDeletes;

    protected $fillable = ['employee_id','name','dob','relationship','marital_status','mobile_number'];

    protected $casts = ['dob' => 'date'];

    public function employee(){ return $this->belongsTo(Employee::class); }
}
