<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RelPackingStore extends Model
{
    use HasFactory;
    protected $table = "rel_pack_stores";
    protected $fillable =[
        "pack_id",
        "receive_details_id",
        "shipper_id"
    ];
    
    public function packing():BelongsTo{
        return $this->belongsTo(Packing::class,"pack_id");
    }
    
    public function receive_details():BelongsTo{
        return $this->belongsTo(ReceiveDetails::class,"receive_details_id");
    }
    
    public function shipper():BelongsTo{
        return $this->belongsTo(Shippers::class,'shipper_id');
    }
            
}
