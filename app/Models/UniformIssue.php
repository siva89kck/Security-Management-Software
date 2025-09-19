<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class UniformIssue extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['employee_id','issue_date','issue_number','remarks'];

    public function items(){
        return $this->hasMany(UniformIssueItem::class, 'issue_id');
    }

    public function employee(){
        return $this->belongsTo(\App\Models\Employee::class, 'employee_id');
    }

    // ✅ auto issue_number generate
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Issue Number → only numbers (YmdHis)
            $model->issue_number = now()->format('YmdHis'); // 20250918235847

            // Issue Date auto fill (optional)
            if (empty($model->issue_date)) {
                $model->issue_date = now();
            }
        });
    }
}
