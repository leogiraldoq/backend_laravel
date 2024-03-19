<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProcessAddWork extends Model
{
    use HasFactory;
    
    protected $table="process_add_work";
    protected $primaryKey="id_add_work";
    protected $fillable=[
        "name",
        "cost",
        "active"
    ];
    
    public function rel_process_add_work():HasMany{
        return $this->hasMany(RelProcessAddWork::class,"add_work_id");
    }
}
