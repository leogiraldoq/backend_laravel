<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quality extends Model
{
    use HasFactory;
    
    protected $table = "quality";
    protected $primaryKey = "id_quality";
    protected $fillable = [
        "process_id",
        "receive_details_id",
        "aprove",
        "observations",
        "user_id"
    ];
    
    
    public function processing():BelongsTo{
        return $this->belongsTo(Processing::class,'process_id');
    }
    
    public function user():BelongsTo{
        return $this->belongsTo(Users::class,'user_id');
    }
    
    public function receive_details():BelongsTo{
        return $this->belongsTo(ReceiveDetails::class,'receive_details_id');
    }
}
