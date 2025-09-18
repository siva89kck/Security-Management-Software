<?php
namespace App\Http\Controllers;

use App\Models\UniformMaster;
use App\Http\Requests\StoreUniformMasterRequest;
use Illuminate\Http\Request;

class UniformMasterController extends Controller
{
    public function index()
    {
        $masters = UniformMaster::with('stock')->paginate(15);
        return view('uniforms.masters.index', compact('masters'));
    }

    public function toggleStatus(UniformMaster $uniform)
    {
        // flip status
        $uniform->status = $uniform->status === 'active' ? 'inactive' : 'active';
        $uniform->save();

        return response()->json([
            'success' => true,
            'status' => $uniform->status
        ]);
    }

    public function create()
    {
        return view('uniforms.masters.create');
    }

    public function store(StoreUniformMasterRequest $r)
    {
        $data = $r->validated();
        $master = UniformMaster::create($data);

        // create initial stock if not exists
        $master->stock()->create([
            'total_purchased' => 0,
            'total_issued' => 0,
            'remaining_stock' => 0
        ]);

        return redirect()->route('masters.index')->with('success', 'Uniform created');
    }

    public function show(UniformMaster $master)
    {
        // if stock relation needed
        $master->load('stock');

        // return a blade view
        return view('uniforms.masters.show', compact('master'));
    }

    public function edit(UniformMaster $master)
    {
        return view('uniforms.masters.edit', compact('master'));
    }

    public function update(Request $r, UniformMaster $master)
    {
        $data = $r->validate([
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric',
            'size' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);
        $master->update($data);

        return redirect()->route('masters.index')->with('success', 'Updated');
    }

    public function destroy(UniformMaster $master)
    {
        $master->delete();
        return back()->with('success', 'Deleted');
    }
}
