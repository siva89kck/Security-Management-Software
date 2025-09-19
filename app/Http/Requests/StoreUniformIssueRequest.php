<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUniformIssueRequest extends FormRequest
{
    public function authorize(){ return true; }

    public function rules(){
        return [
            'employee_id' => 'required|exists:employees,id',
            'issued_by' => 'required|exists:employees,id',
            'issue_date' => 'required|date',
            // 'issue_number' => 'required|unique:uniform_issues,issue_number',
            'remarks' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.uniform_master_id' => 'required|exists:uniform_masters,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'nullable|numeric',
        ];
    }
}
