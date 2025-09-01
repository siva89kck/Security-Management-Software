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

    public function create()
    {
        return view('employees.create');
    }

    public function store(EmployeeStoreRequest $request)
    {
        //dd($request->all());

        $employee = DB::transaction(function () use ($request) {

            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('employees/photos', 'public');
            }

            $employee = Employee::create(array_merge(
                $request->only([
                    'first_name',
                    'last_name',
                    'father_name',
                    'dob',
                    'gender',
                    'age',
                    'phone',
                    'mobile',
                    'alt_mobile',
                    'education_qualification',
                    'marital_status',
                    'nationality',
                    'religion',
                    'caste',
                    'sub_caste',
                    'identification_marks',
                    'remarks',
                    'recommended_by',
                    'recommended_address',
                    'blood_group'
                ]),
                [
                    'photo' => $photoPath,
                    'created_by'  => Auth::id(),
                    'status'     => Auth::user()->role === 'admin' ? 'active' : 'inactive',
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
                if (!empty($lang['language'])) {
                    $employee->languages()->create([
                        'language' => $lang['language'],
                        'read'     => !empty($lang['read']),
                        'write'    => !empty($lang['write']),
                        'speak'    => !empty($lang['speak']),
                    ]);
                }
            }

            // Family Members
            foreach ($request->input('family_members', []) as $fam) {
                if (!empty($fam['name'])) $employee->familyMembers()->create($fam);
            }

            // Experiences
            foreach ($request->input('experiences', []) as $exp) {
                if (!empty($exp['company_name'])) $employee->experiences()->create($exp);
            }


            $official = $request->input('official');
            if (isset($official['role']) && $official['role'] === '--') {
                $official['role'] = null;
            }
            $employee->officialDetail()->Create([], $official);

            // // Payslip
            if ($payslip = $request->input('payslip')) {
                $employee->payslipConfig()->create($payslip);
            }

            // // Banks
            foreach ($request->input('banks', []) as $bank) {
                if (!empty($bank['account_no'])) $employee->bankDetails()->create($bank);
            }

            // // Enclosures + files
            foreach ($request->input('enclosures', []) as $i => $doc) {
                $path = null;
                if ($request->file("enclosures.$i.file")) {
                    $path = $request->file("enclosures.$i.file")->store('employees/docs', 'public');
                }
                $employee->enclosures()->create([
                    'document_type' => $doc['document_type'] ?? null,
                    'original_copy' => $doc['original_copy'] ?? null,
                    'proof_no'      => $doc['proof_no'] ?? null,
                    'file_path'     => $path,
                ]);
            }

            return $employee;
        });

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Employee created', 'id' => $employee->id]);
        }
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

            if ($request->hasFile('photo')) {
                if ($employee->photo) Storage::disk('public')->delete($employee->photo);
                $employee->photo = $request->file('photo')->store('employees/photos', 'public');
            }

            $employee->fill($request->only([
                'first_name',
                'last_name',
                'father_name',
                'dob',
                'gender',
                'age',
                'phone',
                'mobile',
                'alt_mobile',
                'education_qualification',
                'marital_status',
                'nationality',
                'religion',
                'caste',
                'sub_caste',
                'identification_marks',
                'remarks',
                'recommended_by',
                'recommended_address',
                'blood_group'
            ]))->save();

            $employee->status = Auth::user()->role === 'admin' ? 'active' : 'inactive';

            // Re-sync child tables: simple strategy -> delete + recreate (can be optimized)
            $employee->addresses()->delete();
            $addresses = $request->input('addresses', []);
            foreach (['permanent', 'present'] as $type) {
                if (!empty($addresses[$type])) {
                    $employee->addresses()->create(array_merge($addresses[$type], ['type' => $type]));
                }
            }

            $employee->languages()->delete();
            foreach ($request->input('languages', []) as $lang) {
                if (!empty($lang['language'])) {
                    $employee->languages()->create([
                        'language' => $lang['language'],
                        'read' => !empty($lang['read']),
                        'write' => !empty($lang['write']),
                        'speak' => !empty($lang['speak']),
                    ]);
                }
            }

            $employee->familyMembers()->delete();
            foreach ($request->input('family_members', []) as $fam) {
                if (!empty($fam['name'])) $employee->familyMembers()->create($fam);
            }

            $employee->experiences()->delete();
            foreach ($request->input('experiences', []) as $exp) {
                if (!empty($exp['company_name'])) $employee->experiences()->create($exp);
            }

            $employee->officialDetail()->delete();
            if ($official = $request->input('official')) {
                $employee->officialDetail()->create($official);
            }

            $employee->payslipConfig()->delete();
            if ($payslip = $request->input('payslip')) {
                $employee->payslipConfig()->create($payslip);
            }

            $employee->bankDetails()->delete();
            foreach ($request->input('banks', []) as $bank) {
                if (!empty($bank['account_no'])) $employee->bankDetails()->create($bank);
            }


            $employee->enclosures()->delete();

            foreach ($request->input('enclosures', []) as $i => $doc) {
                // default old file_path retain
                $path = $doc['file_path'] ?? null;

                // if new file uploaded → replace
                if ($request->hasFile("enclosures.$i.file")) {
                    // delete old file if exists
                    if (!empty($path)) {
                        Storage::disk('public')->delete($path);
                    }
                    $path = $request->file("enclosures.$i.file")->store('employees/docs', 'public');
                }

                // create new record
                $employee->enclosures()->create([
                    'document_type' => $doc['document_type'] ?? null,
                    'original_copy' => $doc['original_copy'] ?? null,
                    'proof_no'      => $doc['proof_no'] ?? null,
                    'file_path'     => $path,
                ]);
            }
        });

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Employee updated']);
        }
        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Request $request, Employee $employee)
    {
        $employee->delete();
        if ($request->wantsJson()) return response()->json(['message' => 'Employee deleted']);
        return back()->with('success', 'Employee deleted');
    }
}
