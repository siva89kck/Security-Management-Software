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

    // ✅ Auto Purchase Number Generate
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Purchase Number → only numbers (YmdHis)
            $model->purchase_number = now()->format('YmdHis'); // 20250919093012

            // Purchase Date auto fill (optional)
            if (empty($model->purchase_date)) {
                $model->purchase_date = now();
            }
        });
    }
}
