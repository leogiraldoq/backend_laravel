<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RelProcessAddWork extends Model
{
    use HasFactory;
    
    protected $table="rel_pro_work";
    protected $fillable=[
        "process_id",
        "add_work_id"
    ];
    
    public function processing():BelongsTo{
        return $this->belongsTo(Processing::class,"id_process");
    }
    
    public function process_add_work():BelongsTo{
        return $this->belongsTo(ProcessAddWork::class,"id_add_work");
    }
}
