<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUniformPurchaseRequest extends FormRequest
{
    public function authorize(){ return true; }

    // public function rules(){
    //     return [
    //         'purchase_date' => 'required|date',
    //         'purchase_number' => 'required|unique:uniform_purchases,purchase_number',
    //         'supplier_name' => 'required|string',
    //         'remarks' => 'nullable|string',
    //         'items' => 'required|array|min:1',
    //         'items.*.uniform_master_id' => 'required|exists:uniform_masters,id',
    //         'items.*.quantity' => 'required|integer|min:1',
    //         'items.*.price' => 'nullable|numeric',
    //     ];
    // }

    public function rules()
{
    $purchaseId = $this->route('purchase') ? $this->route('purchase')->id : null;

    return [
        'purchase_number' => 'required|unique:uniform_purchases,purchase_number,' . $purchaseId,
        'purchase_date'   => 'required|date',
        'supplier_name'   => 'required|string|max:255',
        'items.*.uniform_master_id' => 'required|exists:uniform_masters,id',
        'items.*.quantity' => 'required|numeric|min:1',
        'items.*.price'    => 'required|numeric|min:0',
    ];
}
}
