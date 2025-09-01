<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeAddress;
use App\Models\EmployeeBankDetail;
use App\Models\EmployeeEnclosure;
use App\Models\EmployeeExperience;
use App\Models\EmployeeFamilyMember;
use App\Models\EmployeeLanguage;
use App\Models\EmployeeOfficialDetail;
use App\Models\EmployeePayslipConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the employees.
     */
    public function index()
    {
        $employees = Employee::with(['officialDetails'])->withTrashed()->get();
        return view('employee_list', compact('employees')); // Corrected view name
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        return view('employee_add'); // Corrected view name
    }

    /**
     * Store a newly created employee in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'pan_card' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'address_proof' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // 1. Create Employee
            $employee = new Employee();
            $employee->first_name = $request->first_name;
            $employee->last_name = $request->last_name;
            $employee->father_name = $request->father_name;
            $employee->dob = $request->dob;
            $employee->gender = $request->gender;
            $employee->age = $request->age;
            $employee->photo = $this->uploadFile($request, 'photo', 'photos');
            $employee->phone = $request->phone;
            $employee->mobile = $request->mobile;
            $employee->alt_mobile = $request->alt_mobile;
            $employee->education_qualification = $request->education_qualification;
            $employee->marital_status = $request->marital_status;
            $employee->nationality = $request->nationality;
            $employee->religion = $request->religion;
            $employee->caste = $request->caste;
            $employee->sub_caste = $request->sub_caste;
            $employee->identification_marks = $request->identification_marks;
            $employee->remarks = $request->remarks;
            $employee->recommended_by = $request->recommended_by;
            $employee->recommended_address = $request->recommended_address;
            $employee->blood_group = $request->blood_group;
            $employee->created_by = Auth::id();
            $employee->save();

            // 2. Create Employee Address
            if ($request->filled('address_line1')) {
                $employee->addresses()->create([
                    'type' => 'permanent',
                    'address_line1' => $request->address_line1,
                    'address_line2' => $request->address_line2,
                    'city' => $request->city,
                    'state' => $request->state,
                    'pincode' => $request->pincode,
                ]);
            }

            // 3. Create Employee Bank Details
            if ($request->filled('bank_name') || $request->filled('account_number')) {
                $employee->bankDetails()->create([
                    'account_holder_name' => $request->account_holder_name,
                    'bank_name' => $request->bank_name,
                    'branch' => $request->branch_name,
                    'account_no' => $request->account_number,
                    'ifsc_code' => $request->ifsc_code,
                ]);
            }

            // 4. Create Employee Enclosures
            if ($request->hasFile('pan_card')) {
                $employee->enclosures()->create([
                    'document_type' => 'PAN', // Changed to a shorter value
                    'original_copy' => 'Xerox',
                    'file_path' => $this->uploadFile($request, 'pan_card', 'documents'),
                ]);
            }
            if ($request->hasFile('address_proof')) {
                $employee->enclosures()->create([
                    'document_type' => 'Aadhar', // Changed to a shorter value
                    'original_copy' => 'Xerox',
                    'file_path' => $this->uploadFile($request, 'address_proof', 'documents'),
                ]);
            }

            // 5. Create Employee Official Details
            $employee->officialDetails()->create([
                //'employee_code' => $request->employee_code,
                'role' => $request->role,
                'date_of_join' => $request->date_of_join,
                'employee_type' => $request->employee_type,
                'salary' => $request->salary,
                'pf_number' => $request->pf_number,
                'esi_number' => $request->esi_number,
                'pf_calculation' => $request->pf_calculation ? 1 : 0,
                'esi_calculation' => $request->esi_calculation ? 1 : 0,
            ]);

            DB::commit();
            return redirect()->route('employees.index')->with('success', 'Employee created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create employee: ' . $e->getMessage());
        }
    }

    /**
     * Show the specified employee.
     */
    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee')); // Corrected view name
    }

    /**
     * Remove the specified employee from storage. (Soft Delete)
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully!');
    }

    /**
     * Restore the specified soft-deleted employee.
     */
    public function restore($id)
    {
        $employee = Employee::withTrashed()->findOrFail($id);
        $employee->restore();
        return redirect()->route('employees.index')->with('success', 'Employee restored successfully!');
    }

    /**
     * Permanently delete the specified employee from storage.
     */
    public function forceDelete($id)
    {
        $employee = Employee::withTrashed()->findOrFail($id);
        $employee->forceDelete();
        return redirect()->route('employees.index')->with('success', 'Employee permanently deleted!');
    }

    private function uploadFile(Request $request, $fieldName, $path)
    {
        if ($request->hasFile($fieldName)) {
            $file = $request->file($fieldName);
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/' . $path, $fileName, 'public');
            return '/storage/' . $filePath;
        }
        return null;
    }
}
