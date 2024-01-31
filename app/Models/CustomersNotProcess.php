<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomersNotProcess extends Model
{
    use HasFactory;
    
    protected $table="customer_not_process";
    protected $fillable=[
        "customer_id",
        "shipper_id"
    ];
    
    public function customer():BelongsTo
    {
        return $this->belongsTo(Costumers::class,'customer_id');
    }
    
    public function shipper():BelongsTo
    {
        return $this->belongsTo(Shippers::class,'shipper_id');
    }
    
}
