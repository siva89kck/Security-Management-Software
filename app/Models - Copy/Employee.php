<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name', 'last_name', 'father_name', 'dob', 'gender', 'age',
        'photo', 'phone', 'mobile', 'alt_mobile', 'education_qualification',
        'marital_status', 'nationality', 'religion', 'caste', 'sub_caste',
        'identification_marks', 'remarks', 'recommended_by', 'recommended_address',
        'blood_group', 'created_by'
    ];

    public function addresses(): HasMany
    {
        return $this->hasMany(EmployeeAddress::class);
    }

    public function languages(): HasMany
    {
        return $this->hasMany(EmployeeLanguage::class);
    }

    public function familyMembers(): HasMany
    {
        return $this->hasMany(EmployeeFamilyMember::class);
    }

    public function experiences(): HasMany
    {
        return $this->hasMany(EmployeeExperience::class);
    }

    public function officialDetails(): HasMany
    {
        return $this->hasMany(EmployeeOfficialDetail::class);
    }

    public function payslipConfigs(): HasMany
    {
        return $this->hasMany(EmployeePayslipConfig::class);
    }

    public function bankDetails(): HasMany
    {
        return $this->hasMany(EmployeeBankDetail::class);
    }

    public function enclosures(): HasMany
    {
        return $this->hasMany(EmployeeEnclosure::class);
    }
}
