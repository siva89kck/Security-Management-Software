<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUniformMasterRequest extends FormRequest
{
    public function authorize(){ return true; }

    public function rules(){
        return [
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric',
            'size' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ];
    }
}
