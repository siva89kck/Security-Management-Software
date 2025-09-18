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
    public function index(){
        $issues = UniformIssue::with('items.master','employee')->paginate(15);
        return view('uniforms.issues.index', compact('issues'));
    }

    public function create(){
        $masters = UniformMaster::all();
        //$employees = \App\Models\Employee::pluck('name','id');
        $employees = \App\Models\Employee::select(DB::raw("CONCAT(first_name, ' ', last_name) as full_name"), 'id')
                                ->pluck('full_name','id');
        return view('uniforms.issues.create', compact('masters','employees'));
    }

    public function store(\App\Http\Requests\StoreUniformIssueRequest $r)
{
    $data = $r->validated();

    DB::beginTransaction();
    try {
        // Save main issue
        $issue = \App\Models\UniformIssue::create([
            'employee_id'  => $data['employee_id'],
            'issue_date'   => $data['issue_date'],
            'issue_number' => $data['issue_number'],
            'remarks'      => $data['remarks'] ?? null,
        ]);

        // Save items + update stock
        foreach ($data['items'] as $item) {
            $total = $item['price'] * $item['quantity'];

            // 1️⃣ create issue item
            \App\Models\UniformIssueItem::create([
                'issue_id'          => $issue->id,
                'uniform_master_id' => $item['uniform_master_id'],
                'quantity'          => $item['quantity'],
                'price'             => $item['price'],
                'total'             => $total,
            ]);

            // 2️⃣ update stock
            $stock = \App\Models\UniformStock::where('uniform_master_id', $item['uniform_master_id'])->first();
            if ($stock) {
                $stock->increment('total_issued', $item['quantity']);
                $stock->decrement('remaining_stock', $item['quantity']);
            }
        }

        DB::commit();

        return redirect()->route('issues.index')
            ->with('success','Uniform Issue Created Successfully');

    } catch (\Throwable $e) {
        DB::rollBack();
        return back()->withInput()->withErrors(['error' => $e->getMessage()]);
    }
}


public function edit(UniformIssue $issue){
    $masters = UniformMaster::all();
    $employees = \App\Models\Employee::select(DB::raw("CONCAT(first_name, ' ', last_name) as full_name"), 'id')
                    ->pluck('full_name','id');

    $issue->load('items'); // load existing items

    return view('uniforms.issues.edit', compact('issue', 'masters', 'employees'));
}

public function update(Request $request, UniformIssue $issue)
{
    $data = $request->validate([
        'employee_id'                => 'required|exists:employees,id',
        'issue_date'                 => 'required|date',
        'remarks'                    => 'nullable|string',
        'items'                      => 'required|array|min:1',
        'items.*.uniform_master_id'  => 'required|exists:uniform_masters,id',
        'items.*.quantity'           => 'required|numeric|min:1',
        'items.*.price'              => 'required|numeric|min:0',
    ]);

    DB::transaction(function() use($issue, $data){
        // 1️⃣ reverse old stock
        foreach($issue->items as $oldItem){
            $stock = \App\Models\UniformStock::where('uniform_master_id',$oldItem->uniform_master_id)->first();
            if($stock){
                $stock->decrement('total_issued', $oldItem->quantity);
                $stock->increment('remaining_stock', $oldItem->quantity);
            }
        }

        // 2️⃣ update main issue
        $issue->update([
            'employee_id' => $data['employee_id'],
            'issue_date'  => $data['issue_date'],
            'remarks'     => $data['remarks'] ?? null,
        ]);

        // 3️⃣ delete old items
        $issue->items()->delete();

        // 4️⃣ create new items + update stock
        foreach($data['items'] as $item){
            $issue->items()->create([
                'uniform_master_id' => $item['uniform_master_id'],
                'quantity'          => $item['quantity'],
                'price'             => $item['price'],
                'total'             => $item['quantity'] * $item['price'],
            ]);

            $stock = \App\Models\UniformStock::where('uniform_master_id',$item['uniform_master_id'])->first();
            if($stock){
                $stock->increment('total_issued', $item['quantity']);
                $stock->decrement('remaining_stock', $item['quantity']);
            }
        }
    });

    return redirect()->route('issues.index')->with('success','Issue Updated Successfully');
}





    public function show(UniformIssue $issue){
        $issue->load('items.master','employee');
        return view('uniforms.issues.show', compact('issue'));
    }

    public function destroy(UniformIssue $issue){
        foreach($issue->items as $it){
            $stock = UniformStock::where('uniform_master_id',$it->uniform_master_id)->first();
            if($stock){
                $stock->decrement('total_issued', $it->quantity);
                $stock->increment('remaining_stock', $it->quantity);
            }
        }
        $issue->delete();
        return back()->with('success','Deleted');
    }
}
