<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class UniformPurchase extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['purchase_date','purchase_number','supplier_name','remarks'];

    public function items(){
        return $this->hasMany(UniformPurchaseItem::class, 'purchase_id');
    }
}
