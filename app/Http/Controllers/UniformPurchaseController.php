<?php
namespace App\Http\Controllers;

use App\Models\UniformPurchase;
use App\Models\UniformPurchaseItem;
use App\Models\UniformStock;
use App\Models\UniformMaster;
use App\Http\Requests\StoreUniformPurchaseRequest;
use Illuminate\Http\Request;
use DB;

class UniformPurchaseController extends Controller
{
    public function index(){
        $purchases = UniformPurchase::with('items.master')->paginate(15);
        return view('uniforms.purchases.index', compact('purchases'));
    }

    public function create(){
        $masters = UniformMaster::all(['id','name','price']); // price column
        return view('uniforms.purchases.create', compact('masters'));
    }


   public function store(StoreUniformPurchaseRequest $r)
{
    try {
        DB::transaction(function() use($r){
            $purchase = UniformPurchase::create($r->only('purchase_date','purchase_number','supplier_name','remarks'));

            foreach($r->items as $it){
                $it['purchase_id'] = $purchase->id;
                $it['total'] = isset($it['price']) ? ($it['price'] * $it['quantity']) : null;

                // create purchase item
                UniformPurchaseItem::create($it);

                // update stock safely
                $stock = UniformStock::firstOrCreate(
                    ['uniform_master_id'=>$it['uniform_master_id']],
                    ['total_purchased'=>0,'total_issued'=>0,'remaining_stock'=>0]
                );
                $stock->increment('total_purchased', $it['quantity']);
                $stock->increment('remaining_stock', $it['quantity']);
            }
        });

        return redirect()->route('purchases.index')
            ->with('success','Stock saved successfully!');
    } catch (\Throwable $e) {
        return back()->withErrors('Error while saving purchase: '.$e->getMessage())->withInput();
    }
}

public function edit(UniformPurchase $purchase)
{
    $purchase->load('items');

    $masters = UniformMaster::all(['id','name','price']);

    return view('uniforms.purchases.edit', compact('purchase', 'masters'));
}

public function update(StoreUniformPurchaseRequest $r, UniformPurchase $purchase)
{
    try {
        DB::transaction(function() use($r, $purchase){
            // Main purchase info update
            $purchase->update($r->only('purchase_date','purchase_number','supplier_name','remarks'));

            // old items delete
            $purchase->items()->delete();

            // new items is add
            foreach($r->items as $it){
                $it['purchase_id'] = $purchase->id;
                $it['total'] = isset($it['price']) ? ($it['price'] * $it['quantity']) : null;

                UniformPurchaseItem::create($it);

                // stock update
                $stock = UniformStock::firstOrCreate(
                    ['uniform_master_id'=>$it['uniform_master_id']],
                    ['total_purchased'=>0,'total_issued'=>0,'remaining_stock'=>0]
                );
                $stock->increment('total_purchased', $it['quantity']);
                $stock->increment('remaining_stock', $it['quantity']);
            }
        });

        return redirect()->route('purchases.index')
            ->with('success','Stock updated successfully!');
    } catch (\Throwable $e) {
        return back()->withErrors('Error while updating purchase: '.$e->getMessage())->withInput();
    }
}




    public function show(UniformPurchase $purchase){
        $purchase->load('items.master');
        return view('uniforms.purchases.show', compact('purchase'));
    }

    public function destroy(UniformPurchase $purchase){
        // rollback stock
        foreach($purchase->items as $it){
            $stock = UniformStock::where('uniform_master_id',$it->uniform_master_id)->first();
            if($stock){
                $stock->decrement('total_purchased', $it->quantity);
                $stock->decrement('remaining_stock', $it->quantity);
            }
        }
        $purchase->delete();
        return back()->with('success','Deleted');
    }
}
