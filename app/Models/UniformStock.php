<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UniformStock extends Model
{
    use HasFactory;

    protected $fillable = ['uniform_master_id','total_purchased','total_issued','remaining_stock'];

    public function master(){
        return $this->belongsTo(UniformMaster::class, 'uniform_master_id');
    }
}
