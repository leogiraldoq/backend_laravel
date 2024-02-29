<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Packing extends Model
{
    use HasFactory;
    
    protected $table = "packing";
    protected $primaryKey ="id_pack";
    protected $fillable = [
        "user_id",
        "customer_id",
        "boutique_id",
        "box_id",
        "weight",
        "quantity"
    ];
    
    
    public function users():BelongsTo{
        return $this->belongsTo(Users::class, "user_id");
    }
    
    public function customers():BelongsTo{
        return $this->belongsTo(Costumers::class,"customer_id");
    }
    
    public function boutiques():BelongsTo{
        return $this->belongsTo(Boutiques::class,"boutique_id");
    }
    
    public function boxes():BelongsTo{
        return $this->belongsTo(Boxes::class,"box_id");
    }
    
    public function relPackStore():HasMany{
        return $this->hasMany(RelPackingStore::class,"pack_id");
    }
    
    public function rel_pack_delivery():HasMany{
        return $this->hasMany(RelPackDelivery::class,'packing_id');
    }
}
