<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeAddress;
use App\Models\EmployeeEnclosure;
use App\Models\EmployeeBankDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with(['addresses', 'bankDetails'])->paginate(10);
        return view('employees.list', compact('employees'));
    }

    public function create()
    {
        return view('employees.add');
    }

    public function store(Request $request)
    {
        // Validation rules
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'nullable|string|max:20',
            'employee_code' => 'required|string|unique:employees,employee_code',
            'address' => 'nullable|string', // A temporary name, to be handled for the address table
            'pan_card' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'address_proof' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'bank_name' => 'nullable|string|max:255',
            'account_holder_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'ifsc_code' => 'nullable|string|max:255',
            'branch_name' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // Employee creation
            $employee = new Employee();
            $employee->first_name = $request->first_name;
            $employee->last_name = $request->last_name;
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->employee_code = $request->employee_code;
            $employee->created_by = auth()->user()->id;

            // File uploads
            if ($request->hasFile('photo')) {
                $employee->photo = $this->uploadFile($request->file('photo'), 'photos');
            }
            $employee->save();

            // Employee Address
            if ($request->filled('address')) {
                EmployeeAddress::create([
                    'employee_id' => $employee->id,
                    'type' => 'present',
                    'address_line1' => $request->address,
                ]);
            }
            // Employee Enclosures
            if ($request->hasFile('pan_card')) {
                EmployeeEnclosure::create([
                    'employee_id' => $employee->id,
                    'document_type' => 'PAN CARD',
                    'original_copy' => 'Xerox', // assuming xerox for file uploads
                    'file_path' => $this->uploadFile($request->file('pan_card'), 'documents'),
                ]);
            }
            if ($request->hasFile('address_proof')) {
                EmployeeEnclosure::create([
                    'employee_id' => $employee->id,
                    'document_type' => 'AADHAR CARD', // assuming address_proof is aadhar
                    'original_copy' => 'Xerox',
                    'file_path' => $this->uploadFile($request->file('address_proof'), 'documents'),
                ]);
            }

            // Employee Bank Details
            if ($request->filled('bank_name') || $request->filled('account_number')) {
                EmployeeBankDetail::create([
                    'employee_id' => $employee->id,
                    'bank_name' => $request->bank_name,
                    'account_holder_name' => $request->account_holder_name,
                    'account_no' => $request->account_number,
                    'ifsc_code' => $request->ifsc_code,
                    'branch' => $request->branch_name,
                ]);
            }
            DB::commit();
            return redirect()->route('employees.index')->with('success', 'Employee added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to add employee: ' . $e->getMessage());
        }
    }

    private function uploadFile($file, $path)
    {
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('uploads/' . $path, $fileName, 'public');
        return '/storage/' . $filePath;
    }
}
