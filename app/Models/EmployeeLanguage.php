<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeLanguage extends Model
{
    use SoftDeletes;

    protected $fillable = ['employee_id','language','read','write','speak'];

    protected $casts = [ 'read'=>'boolean','write'=>'boolean','speak'=>'boolean' ];

    public function employee(){ return $this->belongsTo(Employee::class); }
}
