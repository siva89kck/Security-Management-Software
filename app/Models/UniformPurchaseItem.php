<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UniformPurchaseItem extends Model
{
    use HasFactory;

    protected $table = 'uniform_purchase_items';

    protected $fillable = ['purchase_id','uniform_master_id','quantity','price','total'];

    public function purchase(){
        return $this->belongsTo(UniformPurchase::class, 'purchase_id');
    }

    public function master(){
        return $this->belongsTo(UniformMaster::class, 'uniform_master_id');
    }
}
