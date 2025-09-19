<?php

namespace App\Http\Controllers;

use App\Models\UniformIssue;
use App\Models\UniformIssueItem;
use App\Models\UniformStock;
use App\Models\UniformMaster;
use App\Http\Requests\StoreUniformIssueRequest;
use Illuminate\Http\Request;
use DB;

class UniformIssueController extends Controller
{
    public function index()
    {
        $issues = UniformIssue::with('items.master', 'employee')->paginate(15);
        return view('uniforms.issues.index', compact('issues'));
    }

    public function create()
{
    $masters = UniformMaster::all();

    // 🔹 Employees for "Employee" dropdown (all employees)
    $allEmployees = \App\Models\Employee::select(
            DB::raw("CONCAT(first_name, ' ', last_name) as full_name"),
            'id'
        )
        ->pluck('full_name', 'id');

    // 🔹 Employees for "Issued By" dropdown (only allowed roles)
    $allowedRoles = ['Field Officer(FO)','Security Officer(SO)','Assistant Security Officer(ASO)','Operation Manager(OM)'];
    $issuedByEmployees = \App\Models\Employee::select(
        'employees.id',
        DB::raw("CONCAT(employees.first_name, ' ', employees.last_name, ' - ', employee_official_details.role) as display_name")
    )
    ->join('employee_official_details','employees.id','=','employee_official_details.employee_id')
    ->whereIn('employee_official_details.role', $allowedRoles)
    ->pluck('display_name', 'employees.id');

    return view('uniforms.issues.create', [
        'masters' => $masters,
        'employees' => $allEmployees,
        'issuedByEmployees' => $issuedByEmployees,
    ]);
}


    public function store(StoreUniformIssueRequest $r)
    {
        $data = $r->validated();

        // 🔹 Stock check (before saving)
        $errors = [];
        foreach ($data['items'] as $index => $item) {
            $master = \App\Models\UniformMaster::find($item['uniform_master_id']);
            $stock  = \App\Models\UniformStock::where('uniform_master_id', $item['uniform_master_id'])->first();

            if (!$stock || $stock->remaining_stock < $item['quantity']) {
                $itemName = $master ? $master->name : 'Selected item';
                $available = $stock->remaining_stock ?? 0;
                $errors[] = "Row " . ($index + 1) . ": Not enough stock for {$itemName}. (Available: {$available})";
            }
        }
        if (!empty($errors)) {
            return back()->withErrors($errors)->withInput();
        }

        DB::beginTransaction();
        try {
            // Save main issue
            $issue = UniformIssue::create([
                'employee_id'  => $data['employee_id'],
                'issue_date'   => $data['issue_date'],
                'issued_by'    => $data['issued_by'] ?? null,
                'remarks'      => $data['remarks'] ?? null,
            ]);

            // Save items + update stock
            foreach ($data['items'] as $item) {
                $total = $item['price'] * $item['quantity'];

                UniformIssueItem::create([
                    'issue_id'          => $issue->id,
                    'uniform_master_id' => $item['uniform_master_id'],
                    'quantity'          => $item['quantity'],
                    'price'             => $item['price'],
                    'total'             => $total,
                ]);

                $stock = UniformStock::where('uniform_master_id', $item['uniform_master_id'])->first();
                if ($stock) {
                    $stock->increment('total_issued', $item['quantity']);
                    $stock->decrement('remaining_stock', $item['quantity']);
                }
            }

            DB::commit();

            return redirect()->route('issues.index')
                ->with('success', 'Uniform Issue Created Successfully');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit(UniformIssue $issue)
{
    $masters = UniformMaster::all();

    // 🔹 Employees for "Employee" dropdown (all employees)
    $allEmployees = \App\Models\Employee::select(
            DB::raw("CONCAT(first_name, ' ', last_name) as full_name"),
            'id'
        )
        ->pluck('full_name', 'id');

    // 🔹 Employees for "Issued By" dropdown (only allowed roles)
    $allowedRoles = ['Field Officer(FO)','Security Officer(SO)','Assistant Security Officer(ASO)','Operation Manager(OM)'];
    $issuedByEmployees = \App\Models\Employee::select(
        'employees.id',
        DB::raw("CONCAT(employees.first_name, ' ', employees.last_name, ' - ', employee_official_details.role) as display_name")
    )
    ->join('employee_official_details','employees.id','=','employee_official_details.employee_id')
    ->whereIn('employee_official_details.role', $allowedRoles)
    ->pluck('display_name', 'employees.id');

    $issue->load('items');

    return view('uniforms.issues.edit', [
        'issue' => $issue,
        'masters' => $masters,
        'employees' => $allEmployees,
        'issuedByEmployees' => $issuedByEmployees,
    ]);
}


    public function update(Request $request, UniformIssue $issue)
    {
        $data = $request->validate([
            'employee_id'                => 'required|exists:employees,id',
            'issue_date'                 => 'required|date',
            'issued_by'                  => 'required|exists:employees,id',
            'remarks'                    => 'nullable|string',
            'items'                      => 'required|array|min:1',
            'items.*.uniform_master_id'  => 'required|exists:uniform_masters,id',
            'items.*.quantity'           => 'required|numeric|min:1',
            'items.*.price'              => 'required|numeric|min:0',
        ]);

        // 🔹 Reverse old stock first
        foreach ($issue->items as $oldItem) {
            $stock = UniformStock::where('uniform_master_id', $oldItem->uniform_master_id)->first();
            if ($stock) {
                $stock->decrement('total_issued', $oldItem->quantity);
                $stock->increment('remaining_stock', $oldItem->quantity);
            }
        }

        // 🔹 Stock check for new items
        $errors = [];
        foreach ($data['items'] as $index => $item) {
            $master = UniformMaster::find($item['uniform_master_id']);
            $stock  = UniformStock::where('uniform_master_id', $item['uniform_master_id'])->first();

            if (!$stock || $stock->remaining_stock < $item['quantity']) {
                $itemName = $master ? $master->name : 'Selected item';
                $available = $stock->remaining_stock ?? 0;
                $errors[] = "Row " . ($index + 1) . ": Not enough stock for {$itemName}. (Available: {$available})";
            }
        }
        if (!empty($errors)) {
            // restore old stock if error
            foreach ($issue->items as $oldItem) {
                $stock = UniformStock::where('uniform_master_id', $oldItem->uniform_master_id)->first();
                if ($stock) {
                    $stock->increment('total_issued', $oldItem->quantity);
                    $stock->decrement('remaining_stock', $oldItem->quantity);
                }
            }
            return back()->withErrors($errors)->withInput();
        }

        DB::transaction(function () use ($issue, $data) {
            // update main issue
            $issue->update([
                'employee_id' => $data['employee_id'],
                'issue_date'  => $data['issue_date'],
                'issued_by'   => $data['issued_by'] ?? null,
                'remarks'     => $data['remarks'] ?? null,
            ]);

            // delete old items
            $issue->items()->delete();

            // create new items + update stock
            foreach ($data['items'] as $item) {
                $issue->items()->create([
                    'uniform_master_id' => $item['uniform_master_id'],
                    'quantity'          => $item['quantity'],
                    'price'             => $item['price'],
                    'total'             => $item['quantity'] * $item['price'],
                ]);

                $stock = UniformStock::where('uniform_master_id', $item['uniform_master_id'])->first();
                if ($stock) {
                    $stock->increment('total_issued', $item['quantity']);
                    $stock->decrement('remaining_stock', $item['quantity']);
                }
            }
        });

        return redirect()->route('issues.index')->with('success', 'Issue Updated Successfully');
    }

    public function show(UniformIssue $issue)
    {
        $issue->load('items.master', 'employee');
        return view('uniforms.issues.show', compact('issue'));
    }

    public function destroy(UniformIssue $issue)
    {
        foreach ($issue->items as $it) {
            $stock = UniformStock::where('uniform_master_id', $it->uniform_master_id)->first();
            if ($stock) {
                $stock->decrement('total_issued', $it->quantity);
                $stock->increment('remaining_stock', $it->quantity);
            }
        }
        $issue->delete();
        return back()->with('success', 'Deleted');
    }
}
