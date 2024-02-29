<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RelPackDelivery extends Model
{
    use HasFactory;
    protected $table = 'rel_pack_delivery';
    protected $fillable = [
        'packing_id',
        'delivery_id'
    ];
    
    public function packing():BelongsTo{
        return $this->belongsTo(Packing::class,'packing_id');
    }
    
    public function delivery():BelongsTo{
        return $this->belongsTo(Delivery::class,'delivery_id');
    }
}
