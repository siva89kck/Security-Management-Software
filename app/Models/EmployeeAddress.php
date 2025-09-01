<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeAddress extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'employee_id','type','address_line1','address_line2','city','state','pincode'
    ];

    public function employee(){ return $this->belongsTo(Employee::class); }
}
