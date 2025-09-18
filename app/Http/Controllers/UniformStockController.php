<?php
namespace App\Http\Controllers;

use App\Models\UniformStock;

class UniformStockController extends Controller
{
    public function index(){
        $stocks = UniformStock::with('master')->paginate(20);
        return view('uniforms.stocks.index', compact('stocks'));
    }

    public function show(UniformStock $stock){
        $stock->load('master');
        return view('uniforms.stocks.show', compact('stock'));
    }
}
