<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeEnclosure extends Model
{
    use SoftDeletes;

    protected $fillable = [ 'employee_id','document_type','original_copy','proof_no','file_path' ];

    public function employee(){ return $this->belongsTo(Employee::class); }
}
