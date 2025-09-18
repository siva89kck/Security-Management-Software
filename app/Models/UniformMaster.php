<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UniformMaster extends Model
{
    use HasFactory;

    protected $fillable = ['name','price','size','description'];

    public function purchaseItems(){
        return $this->hasMany(UniformPurchaseItem::class, 'uniform_master_id');
    }

    public function issueItems(){
        return $this->hasMany(UniformIssueItem::class, 'uniform_master_id');
    }

    public function stock(){
        return $this->hasOne(UniformStock::class, 'uniform_master_id');
    }
}
