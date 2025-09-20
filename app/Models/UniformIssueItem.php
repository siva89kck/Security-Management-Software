<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UniformIssueItem extends Model
{
    use HasFactory;

    protected $table = 'uniform_issue_items';

    protected $fillable = ['issue_id','uniform_master_id','size','quantity','price','total'];

    public function issue(){
        return $this->belongsTo(UniformIssue::class, 'issue_id');
    }

    public function master(){
        return $this->belongsTo(UniformMaster::class, 'uniform_master_id');
    }
}
