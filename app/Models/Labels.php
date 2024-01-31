<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Labels extends Model
{
    use HasFactory;
    
    protected $table="labels";
    protected $primaryKey="id_label";
    protected $fillable=[
        "customer_id",
        "name",
        "quantity",
        "sample_image"
    ];
    
    
    public function customers():BelongsTo{
        return $this->belongsTo(Costumers::class,'customer_id');
    }
}
