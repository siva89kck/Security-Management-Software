<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeStoreRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
{
    return [
        'first_name' => ['nullable','string','max:255'],   // required நீக்கப்பட்டது
        'last_name'  => ['nullable','string','max:255'],   // required நீக்கப்பட்டது
        'dob'        => ['nullable','date'],
        'gender'     => ['nullable','in:male,female,other'],
        'age'        => ['nullable','integer','min:0','max:120'],
        'photo'      => ['nullable','image','max:2048'],

        'addresses.permanent.address_line1' => ['nullable','string','max:255'],
        'addresses.permanent.city'          => ['nullable','string','max:255'],
        'addresses.permanent.state'         => ['nullable','string','max:255'],
        'addresses.permanent.pincode'       => ['nullable','string','max:20'],

        'addresses.present.address_line1'   => ['nullable','string','max:255'],
        'addresses.present.city'            => ['nullable','string','max:255'],
        'addresses.present.state'           => ['nullable','string','max:255'],
        'addresses.present.pincode'         => ['nullable','string','max:20'],

        'languages'              => ['nullable','array'],
        'languages.*.language'   => ['nullable','string','max:100'], // required_with நீக்கப்பட்டது
        'languages.*.read'       => ['nullable','boolean'],
        'languages.*.write'      => ['nullable','boolean'],
        'languages.*.speak'      => ['nullable','boolean'],

        'family_members'               => ['nullable','array'],
        'family_members.*.name'        => ['nullable','string'], // required_with நீக்கப்பட்டது
        'family_members.*.dob'         => ['nullable','date'],
        'family_members.*.relationship'=> ['nullable','string','max:100'],
        'family_members.*.marital_status'=> ['nullable','string','max:100'],

        'experiences'                => ['nullable','array'],
        'experiences.*.company_name' => ['nullable','string'], // required_with நீக்கப்பட்டது
        'experiences.*.designation'  => ['nullable','string'], // required_with நீக்கப்பட்டது
        'experiences.*.experience'   => ['nullable','string','max:50'],

        'official.role'            => ['nullable','in:Security Guard,Admin,Supervisor,Field Officer'],
        'official.date_of_join'    => ['nullable','date'],
        'official.employee_type'   => ['nullable','in:Permanent,Temporary'],
        'official.salary'          => ['nullable','numeric','min:0'],
        'official.pf_number'       => ['nullable','string','max:100'],
        'official.esi_number'      => ['nullable','string','max:100'],
        'official.pf_calculation'  => ['nullable','boolean'],
        'official.esi_calculation' => ['nullable','boolean'],

        'payslip.basic'            => ['nullable','numeric'],
        'payslip.allowance1'       => ['nullable','numeric'],
        'payslip.hra'              => ['nullable','numeric'],
        'payslip.allowance2'       => ['nullable','numeric'],
        'payslip.da'               => ['nullable','numeric'],
        'payslip.gratuity'         => ['nullable','numeric'],
        'payslip.travel_allowance' => ['nullable','numeric'],
        'payslip.bonus'            => ['nullable','numeric'],
        'payslip.leave_allowance'  => ['nullable','numeric'],
        'payslip.other_allowance'  => ['nullable','numeric'],

        'banks'                        => ['nullable','array'],
        'banks.*.account_holder_name'  => ['nullable','string'], // required_with நீக்கப்பட்டது
        'banks.*.bank_name'            => ['nullable','string'], // required_with நீக்கப்பட்டது
        'banks.*.account_no'           => ['nullable','string'], // required_with நீக்கப்பட்டது
        'banks.*.ifsc_code'            => ['nullable','string'], // required_with நீக்கப்பட்டது

        'enclosures'                   => ['nullable','array'],
        'enclosures.*.document_type'   => ['nullable','in:PAN CARD,AADHAR CARD,VOTER ID,RATION CARD,Driving License,SCHOOL CERTIFICATE,DEGREE CERTIFICATE'], // required_with நீக்கப்பட்டது
        'enclosures.*.original_copy'   => ['nullable','in:Original,Xerox'],
        'enclosures.*.proof_no'        => ['nullable','string','max:100'],
        'enclosures.*.file'            => ['nullable','file','mimes:jpg,jpeg,png,pdf','max:4096'],
    ];
}
}
