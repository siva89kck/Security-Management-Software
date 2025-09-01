<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeOfficialDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'employee_id','role','date_of_join','employee_type','salary','pf_number',
        'esi_number','pf_calculation','esi_calculation'
    ];

    protected $casts = [ 'date_of_join'=>'date', 'pf_calculation'=>'boolean', 'esi_calculation'=>'boolean' ];

    public function employee(){ return $this->belongsTo(Employee::class); }
}
