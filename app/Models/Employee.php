<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name','last_name','father_name','dob','gender','age','photo',
        'phone','mobile','alt_mobile','education_qualification','marital_status',
        'nationality','religion','caste','sub_caste','identification_marks','remarks',
        'recommended_by','recommended_address','blood_group','created_by','employee_code','status'
    ];

    protected $casts = [
        'dob' => 'date',
    ];

    // Auto-generate employee_code
   protected static function booted()
{
    static::created(function ($employee) {
        if (empty($employee->employee_code)) {
            // Format: EMP-1000 + id
            $employee->employee_code = 'EMP-' . (1000 + $employee->id);
            $employee->save();
        }
    });
}

    public function addresses(){ return $this->hasMany(EmployeeAddress::class); }
    public function languages(){ return $this->hasMany(EmployeeLanguage::class); }
    public function familyMembers(){ return $this->hasMany(EmployeeFamilyMember::class); }
    public function experiences(){ return $this->hasMany(EmployeeExperience::class); }
    public function officialDetail(){ return $this->hasOne(EmployeeOfficialDetail::class); }
    public function payslipConfig(){ return $this->hasOne(EmployeePayslipConfig::class); }
    public function bankDetails(){ return $this->hasMany(EmployeeBankDetail::class); }
    public function enclosures(){ return $this->hasMany(EmployeeEnclosure::class); }
}
