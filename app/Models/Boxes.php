<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Boxes extends Model
{
    use HasFactory;
    
    protected $table="boxes";
    protected $primaryKey="id_box";
    protected $fillable=[
        'product_id',
        'dimensions',
        'active'
    ];
    
    public function receive_details():HasMany{
        return $this->hasMany(ReceiveDetails::class,'box_id');
    }
    
    public function products():BelongsTo{
        return $this->belongsTo(Products::class, "product_id");
    }
    
    public function packing():HasMany{
        return $this->hasMany(Packing::class,'box_id');
    }
}
