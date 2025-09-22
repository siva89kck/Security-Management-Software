<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Models\{Employee, EmployeeAddress, EmployeeLanguage, EmployeeFamilyMember, EmployeeExperience, EmployeeOfficialDetail, EmployeePayslipConfig, EmployeeBankDetail, EmployeeEnclosure};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with(['officialDetail', 'addresses' => function ($q) {
            $q->where('type', 'present');
        }])->latest()->paginate(10);

        if (request()->wantsJson()) {
            return response()->json($employees);
        }

        return view('employees.index', compact('employees'));
    }

    public function toggleStatus($id)
    {
        $employee = Employee::findOrFail($id);

        $employee->status = $employee->status === 'active' ? 'inactive' : 'active';
        $employee->save();

        return response()->json([
            'success' => true,
            'status' => $employee->status
        ]);
    }


    public function create()
    {
        return view('employees.create');
    }

    public function store(EmployeeStoreRequest $request)
{
    $employee = DB::transaction(function () use ($request) {

        // Photo
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('employees/photos', 'public');
        }

        // Employee basic info
        $employee = Employee::create(array_merge(
            $request->only([
                'first_name','last_name','father_name','dob','gender','age',
                'phone','mobile','alt_mobile','education_qualification','marital_status',
                'nationality','religion','caste','sub_caste','identification_marks',
                'remarks','recommended_by','recommended_address','blood_group'
            ]),
            [
                'photo' => $photoPath,
                'created_by' => Auth::id(),
                'status' => Auth::user()->role === 'admin' ? 'active' : 'inactive',
            ]
        ));

        // Addresses
        $addresses = $request->input('addresses', []);
        foreach (['permanent', 'present'] as $type) {
            if (!empty($addresses[$type])) {
                $employee->addresses()->create(array_merge($addresses[$type], ['type' => $type]));
            }
        }

        // Languages
        foreach ($request->input('languages', []) as $lang) {
            if (!empty($lang['language']) || !empty($lang['read']) || !empty($lang['write']) || !empty($lang['speak'])) {
                $employee->languages()->create([
                    'language' => $lang['language'] ?? null,
                    'read' => !empty($lang['read']),
                    'write' => !empty($lang['write']),
                    'speak' => !empty($lang['speak']),
                ]);
            }
        }

        // Family Members
        foreach ($request->input('family_members', []) as $fam) {
            if (!empty($fam['name']) || !empty($fam['dob']) || !empty($fam['relationship']) || !empty($fam['marital_status'])) {
                $employee->familyMembers()->create([
                    'name' => $fam['name'] ?? null,
                    'dob' => $fam['dob'] ?? null,
                    'relationship' => $fam['relationship'] ?? null,
                    'marital_status' => $fam['marital_status'] ?? null,
                ]);
            }
        }

        // Experiences
        foreach ($request->input('experiences', []) as $exp) {
            if (!empty($exp['company_name']) || !empty($exp['designation']) || !empty($exp['experience'])) {
                $employee->experiences()->create([
                    'company_name' => $exp['company_name'] ?? null,
                    'designation' => $exp['designation'] ?? null,
                    'experience' => $exp['experience'] ?? null,
                ]);
            }
        }

        // Official Details (fix applied here)
        $official = $request->input('official', []);
        if (isset($official['role']) && $official['role'] === '--') {
            $official['role'] = null;
        }
        $employee->officialDetail()->create($official);

        // Payslip
        if ($payslip = $request->input('payslip')) {
            $employee->payslipConfig()->create($payslip);
        }

        // Banks
        foreach ($request->input('banks', []) as $bank) {
            if (!empty($bank['account_no']) || !empty($bank['bank_name']) || !empty($bank['account_holder_name']) || !empty($bank['ifsc_code'])) {
                $employee->bankDetails()->create([
                    'account_holder_name' => $bank['account_holder_name'] ?? null,
                    'bank_name' => $bank['bank_name'] ?? null,
                    'account_no' => $bank['account_no'] ?? null,
                    'ifsc_code' => $bank['ifsc_code'] ?? null,
                ]);
            }
        }

        // Enclosures
        foreach ($request->input('enclosures', []) as $i => $doc) {
            $path = null;
            if ($request->file("enclosures.$i.file")) {
                $path = $request->file("enclosures.$i.file")->store('employees/docs', 'public');
            }

            if (!empty($doc['document_type']) || !empty($doc['original_copy']) || !empty($doc['proof_no']) || $path) {
                $employee->enclosures()->create([
                    'document_type' => $doc['document_type'] ?? null,
                    'original_copy' => $doc['original_copy'] ?? null,
                    'proof_no' => $doc['proof_no'] ?? null,
                    'file_path' => $path,
                ]);
            }
        }

        return $employee;
    });

    return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
}


    public function show(Employee $employee)
    {
        $employee->load(['addresses', 'languages', 'familyMembers', 'experiences', 'officialDetail', 'payslipConfig', 'bankDetails', 'enclosures']);
        $payslip = $employee->payslipConfig; // get payslip

        return view('employees.show', compact('employee', 'payslip'));
    }

    public function edit(Employee $employee)
    {
        $employee->load([
            'addresses',
            'languages',
            'familyMembers',
            'experiences',
            'officialDetail',
            'payslipConfig',
            'bankDetails',
            'enclosures'
        ]);

        // Map addresses into ['permanent'=>[], 'present'=>[]]
        $addresses = [
            'permanent' => optional($employee->addresses->where('type', 'permanent')->first())->only([
                'address_line1',
                'address_line2',
                'city',
                'state',
                'pincode'
            ]) ?? [],
            'present' => optional($employee->addresses->where('type', 'present')->first())->only([
                'address_line1',
                'address_line2',
                'city',
                'state',
                'pincode'
            ]) ?? [],
        ];

        // Pass officialDetail as $employeeOfficial
        $employeeOfficial = $employee->officialDetail;
        $payslip = $employee->payslipConfig;

        return view('employees.edit', compact('employee', 'addresses', 'employeeOfficial', 'payslip'));
    }


    public function update(EmployeeUpdateRequest $request, Employee $employee)
{
    DB::transaction(function () use ($request, $employee) {

        // Photo
        if ($request->hasFile('photo')) {
            if ($employee->photo) Storage::disk('public')->delete($employee->photo);
            $employee->photo = $request->file('photo')->store('employees/photos', 'public');
        }

        // Basic info
        $employee->fill($request->only([
            'first_name','last_name','father_name','dob','gender','age',
            'phone','mobile','alt_mobile','education_qualification','marital_status',
            'nationality','religion','caste','sub_caste','identification_marks',
            'remarks','recommended_by','recommended_address','blood_group'
        ]))->save();

        $employee->status = Auth::user()->role === 'admin' ? 'active' : 'inactive';

        /** -------------------------
         * Addresses (One-to-Many)
         * ------------------------- */
        $employee->addresses()->delete();
        $addresses = $request->input('addresses', []);
        foreach (['permanent', 'present'] as $type) {
            if (!empty($addresses[$type])) {
                $employee->addresses()->create(array_merge($addresses[$type], ['type' => $type]));
            }
        }

        /** -------------------------
         * Languages (One-to-Many)
         * ------------------------- */
        $employee->languages()->delete();
        foreach ($request->input('languages', []) as $lang) {
            if (!empty($lang['language']) || !empty($lang['read']) || !empty($lang['write']) || !empty($lang['speak'])) {
                $employee->languages()->create([
                    'language' => $lang['language'] ?? null,
                    'read' => !empty($lang['read']),
                    'write' => !empty($lang['write']),
                    'speak' => !empty($lang['speak']),
                ]);
            }
        }

        /** -------------------------
         * Family Members (One-to-Many)
         * ------------------------- */
        $employee->familyMembers()->delete();
        foreach ($request->input('family_members', []) as $fam) {
            if (!empty($fam['name']) || !empty($fam['dob']) || !empty($fam['relationship']) || !empty($fam['marital_status'])) {
                $employee->familyMembers()->create([
                    'name' => $fam['name'] ?? null,
                    'dob' => $fam['dob'] ?? null,
                    'relationship' => $fam['relationship'] ?? null,
                    'marital_status' => $fam['marital_status'] ?? null,
                ]);
            }
        }

        /** -------------------------
         * Experiences (One-to-Many)
         * ------------------------- */
        $employee->experiences()->delete();
        foreach ($request->input('experiences', []) as $exp) {
            if (!empty($exp['company_name']) || !empty($exp['designation']) || !empty($exp['experience'])) {
                $employee->experiences()->create([
                    'company_name' => $exp['company_name'] ?? null,
                    'designation' => $exp['designation'] ?? null,
                    'experience' => $exp['experience'] ?? null,
                ]);
            }
        }

        /** -------------------------
         * Official Details (One-to-One)
         * ------------------------- */
        if ($official = $request->input('official')) {
            if (isset($official['role']) && $official['role'] === '--') $official['role'] = null;
            $employee->officialDetail()->updateOrCreate(
                ['employee_id' => $employee->id],
                $official
            );
        }

        /** -------------------------
         * Payslip Config (One-to-One)
         * ------------------------- */
        if ($payslip = $request->input('payslip')) {
            $employee->payslipConfig()->updateOrCreate(
                ['employee_id' => $employee->id],
                $payslip
            );
        }

        /** -------------------------
         * Bank Details (One-to-Many)
         * ------------------------- */
        $employee->bankDetails()->delete();
        foreach ($request->input('banks', []) as $bank) {
            if (!empty($bank['account_no']) || !empty($bank['bank_name']) || !empty($bank['account_holder_name']) || !empty($bank['ifsc_code'])) {
                $employee->bankDetails()->create([
                    'account_holder_name' => $bank['account_holder_name'] ?? null,
                    'bank_name' => $bank['bank_name'] ?? null,
                    'account_no' => $bank['account_no'] ?? null,
                    'ifsc_code' => $bank['ifsc_code'] ?? null,
                ]);
            }
        }

        /** -------------------------
         * Enclosures (One-to-Many + File Upload)
         * ------------------------- */
        $employee->enclosures()->delete();
        foreach ($request->input('enclosures', []) as $i => $doc) {
            $path = $doc['file_path'] ?? null;
            if ($request->hasFile("enclosures.$i.file")) {
                if (!empty($path)) Storage::disk('public')->delete($path);
                $path = $request->file("enclosures.$i.file")->store('employees/docs', 'public');
            }
            if (!empty($doc['document_type']) || !empty($doc['original_copy']) || !empty($doc['proof_no']) || $path) {
                $employee->enclosures()->create([
                    'document_type' => $doc['document_type'] ?? null,
                    'original_copy' => $doc['original_copy'] ?? null,
                    'proof_no' => $doc['proof_no'] ?? null,
                    'file_path' => $path,
                ]);
            }
        }
    });

    return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
}



    public function destroy(Request $request, Employee $employee)
    {
        $employee->delete();
        if ($request->wantsJson()) return response()->json(['message' => 'Employee deleted']);
        return back()->with('success', 'Employee deleted');
    }
}
