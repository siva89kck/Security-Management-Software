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
    // Show all purchases
    public function index(){
        $purchases = UniformPurchase::with('items.master')->paginate(15);
        return view('uniforms.purchases.index', compact('purchases'));
    }

    // Show create form
    public function create(){
        // size column explode to array for JS dropdown
        $masters = UniformMaster::all(['id','name','price','size'])->map(function($m){
            $m->sizes = $m->size ? explode(',', $m->size) : [];
            return $m;
        });
        return view('uniforms.purchases.create', compact('masters'));
    }

    // Store new purchase
    public function store(StoreUniformPurchaseRequest $r)
    {
        try {
            DB::transaction(function() use($r){
                $purchase = UniformPurchase::create($r->only('purchase_date','purchase_number','supplier_name','remarks'));

                foreach($r->items as $it){
                    $it['purchase_id'] = $purchase->id;
                    $it['total'] = isset($it['price']) ? ($it['price'] * $it['quantity']) : null;
                    $it['size'] = $it['size'] ?? null;

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

    // Show edit form
    public function edit(UniformPurchase $purchase)
    {
        $purchase->load('items');

        $masters = UniformMaster::all(['id','name','price','size'])->map(function($m){
            $m->sizes = $m->size ? explode(',', $m->size) : [];
            return $m;
        });

        return view('uniforms.purchases.edit', compact('purchase', 'masters'));
    }

    // Update purchase
    public function update(StoreUniformPurchaseRequest $r, UniformPurchase $purchase)
    {
        try {
            DB::transaction(function() use($r, $purchase){
                $purchase->update($r->only('purchase_date','purchase_number','supplier_name','remarks'));

                // delete old items
                $purchase->items()->delete();

                // add new items
                foreach($r->items as $it){
                    $it['purchase_id'] = $purchase->id;
                    $it['total'] = isset($it['price']) ? ($it['price'] * $it['quantity']) : null;
                    $it['size'] = $it['size'] ?? null;

                    UniformPurchaseItem::create($it);

                    // update stock
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

    // Show purchase details
    public function show(UniformPurchase $purchase){
        $purchase->load('items.master');
        return view('uniforms.purchases.show', compact('purchase'));
    }

    // Delete purchase
    public function destroy(UniformPurchase $purchase){
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
