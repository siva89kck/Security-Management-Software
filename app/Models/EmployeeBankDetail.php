<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeBankDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'employee_id','account_holder_name','bank_name','branch','account_no','card_no','ifsc_code'
    ];

    public function employee(){ return $this->belongsTo(Employee::class); }
}
