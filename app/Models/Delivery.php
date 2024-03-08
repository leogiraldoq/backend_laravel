<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use \Illuminate\Database\Eloquent\Relations\HasMany;

class Delivery extends Model
{
    use HasFactory;
    
    protected $table = "delivery";
    protected $primaryKey = "id_delivery";
    protected $fillable = [
        "names",
        "pickup_id",
        "user_id",
        "photo",
        "signature",
        "ticket",
        "follow_number",
        "email"
    ];
    
    public function pick_up_company(): BelongsTo
    {
        return $this->belongsTo(PickUpCompany::class,'pickup_id');
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(Users::class,'user_id');
    }
    
    public function rel_pack_delivery():HasMany{
        return $this->hasMany(RelPackDelivery::class,'delivery_id');
    }
    
}
